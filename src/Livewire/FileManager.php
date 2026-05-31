<?php

namespace VkmApps\XForm\Livewire;

use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use League\Flysystem\PathTraversalDetected;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;
use RuntimeException;

class FileManager extends Component
{
    use WithFileUploads;

    #[Locked]
    public string $disk_name; // the storage disk being used

    #[Locked]
    public bool $standalone = true; // if filemanager is used as standalone

    #[Locked]
    public string $allowed_mime_types; // used for file input accept field

    #[Locked]
    public ?string $uuid = null; // Unique id used for events

    public string $current_path = '/'; // Current path of the gallery
    public $files = []; // Files in the current folder
    public $selected_image = null; // Selected image for preview

    public $media_file; // File to upload

    public ?string $folder_name = null; // Selected image for preview

    public ?string $error = null; // show error in frontend

    public function mount(): void
    {
        $this->disk_name = config('x-form.disk.name');
        $this->allowed_mime_types = $this->getBrowserMimeTypes();
    }

    // Fetch the contents of the current path (gallery or subfolders)
    public function loadGallery(string $path = '/'): void
    {
        // Normalize slashes
        $path = str($path)->replace(['//', '\\/'], '/')->value();

        try {
            $this->files = [];
            $this->current_path = $path;
            $this->getFiles();
        } catch (PathTraversalDetected $e) {
            // Silently reset to root
            $this->files = [];
            $this->current_path = '/';
            $this->getFiles();
        }
    }

    protected function getFiles(): void
    {
        // Folders
        foreach ($this->disk()->directories($this->current_path) as $folder) {
            $name = basename($folder);

            $this->files[] = $this->makeItem(
                name: $name,
                type: 'folder',
                path: str("$this->current_path/$name")->replace('//', '/')->value(),
                url: $this->disk()->url($folder)
            );
        }

        // Files
        foreach ($this->disk()->files($this->current_path) as $item) {
            $name = basename($item);

            $this->files[] = $this->makeItem(
                name: $name,
                type: $this->getFileTypeName($item),
                path: str("$this->current_path/$name")->replace('//', '/')->value(),
                url: $this->disk()->url($item),
                modified_at: Carbon::parse($this->disk()->lastModified($item))->toFormattedDateString(),
            );
        }
    }

    protected function getFileTypeName(string $path): string
    {
        // List of all recognized image extensions
        $image_extensions = [
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico'
        ];

        return in_array(
            strtolower(pathinfo($path, PATHINFO_EXTENSION)),
            $image_extensions
        ) ? 'image' : 'file';
    }

    protected function makeItem(
        string $name,
        string $type,
        string $path,
        string $url,
        ?string $modified_at = null,
    ): array {
        return compact('name', 'type', 'path', 'url', 'modified_at');
    }

    protected function disk(): Filesystem
    {
        return Storage::disk($this->disk_name);
    }

    protected function getBrowserMimeTypes(): string
    {
        // Get allowed types from config
        $types = explode(',', config('x-form.disk.mime_types'));

        // Map extensions to mime types for browser accept attribute
        return collect($types)->map(function ($type) {
            return match (strtolower($type)) {
                // Images (use extensions)
                'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico' => '.'.$type,
                // Documents (MIME types)
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xls' => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'csv' => '.csv',
                'txt' => 'text/plain',
                'rtf' => 'application/rtf',
                'ppt' => 'application/vnd.ms-powerpoint',
                'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                // Videos
                'mp4' => 'video/mp4',
                'webm' => 'video/webm',
                'mov' => 'video/quicktime',
                // Audio
                'mp3' => 'audio/mpeg',
                'wav' => 'audio/wav',
                'ogg' => 'audio/ogg',
                default => null, // ignore unknown types
            };
        })->filter()->implode(', ');
    }

    // Upload the image when the user selects one
    public function updatedMediaFile($file): void
    {
        $this->reset('error');

        try {
            // Validate the file
            $this->validate([
                'media_file' => $this->fileRules(),
            ]);

            // Temporarily store the file locally
            $temp_path = $file->getRealPath();

            // Check for viruses if is set in config
            if (!$this->scanFile($temp_path)) {
                $this->error = 'The uploaded file contains a virus and cannot be uploaded.';
                return;
            }
        } catch (ValidationException $e) {
            $this->error = $e->getMessage();
            return;
        } catch (RuntimeException $e) {
            $this->error = $e->getMessage();
            return;
        }

        $real_filename = $file->getClientOriginalName();

        // Check if file already exists in the directory
        $file_fath = $this->current_path.'/'.$real_filename;

        // If the file already exists, append a unique ID to the filename
        if ($this->disk()->exists($file_fath)) {
            // Append uniqid() to the filename to make it unique
            $filenameWithoutExtension = pathinfo($real_filename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            // Generate a new filename with uniqid()
            $real_filename = $filenameWithoutExtension.'-'.uniqid().'.'.$extension;
        }

        // Store the file with the updated (or original) filename
        $this->disk()->putFileAs($this->current_path, $file, $real_filename);

        $this->loadGallery($this->current_path);
    }

    // Gather rules validating file
    private function fileRules(): array
    {
        $rules = ['required'];
        $livewire_max = config('livewire.max_upload_size'); // KB
        $package_max = config('xform.disk.filesize');      // KB

        $rules[] = 'max:'.$package_max
            ? min($package_max, $livewire_max)
            : $livewire_max;

        $mime_types = config('x-form.disk.mime_types');
        if ($mime_types) {
            $rules[] = "mimes:$mime_types";
        }

        return $rules;
    }

    // Get files and folders from a specific directory
    public function updatedFolderName($value): void
    {
        $this->reset('error');

        // Normalize input
        $slug = str($value)->slug()->value();
        $slug = rtrim($slug, '. '); // remove trailing dots/spaces

        // Check Windows reserved names
        $windows_reserved = [
            'con','prn','aux','nul',
            'com1','com2','com3','com4','com5','com6','com7','com8','com9',
            'lpt1','lpt2','lpt3','lpt4','lpt5','lpt6','lpt7','lpt8','lpt9',
        ];

        if (in_array($slug, $windows_reserved, true)) {
            $this->error = __('Invalid folder name. Avoid reserved system names and special characters.');
            return;
        }

        $this->folder_name = $slug;

        // Validate
        try {
            $this->validate([
                'folder_name' => 'required|string|max:200|regex:/^[a-zA-Z0-9-_]+$/',
            ]);
        } catch (ValidationException $e) {
            $this->error = $e->getMessage();
            return;
        }

        // Build path safely
        $full_path = str($this->current_path . '/' . $this->folder_name)
            ->replace(['//', '\\'], '/')
            ->trim('/') // optional
            ->value();

        // Create the folder
        if ($this->disk()->makeDirectory($full_path)) {
            $this->loadGallery($full_path);
        } else {
            $this->error = __('Failed to create the folder.');
        }
    }

    public function deleteDirectory(): void
    {
        $path = $this->current_path;

        // Safety checks
        if (!$path || $path === '/' || str_contains($path, '.')) {
            abort(404, 'Invalid directory path.');
        }

        $disk = $this->disk();
        $disk_root = rtrim($disk->path(''), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $target_path = rtrim($disk->path($path), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        // Ensure we don't delete outside root
        if (!str_starts_with($target_path, $disk_root)) {
            abort(403, 'Directory is outside allowed root.');
        }

        try {
            // Recursively delete contents
            $this->deleteRecursively($path);

            // Delete the empty directory
            if ($disk->exists($path)) {
                $disk->deleteDirectory($path);
            }

            $this->loadGallery();
        } catch (Exception $e) {
            $this->error = 'Failed to delete directory. Check logs for details.';
            logger()->error("Failed to delete directory {$path}: ".$e->getMessage());
            session()->flash('error', 'Failed to delete directory. Check logs for details.');
        }
    }

    private function deleteRecursively(string $path): void
    {
        $disk = $this->disk();

        // Normalize root and target paths
        $disk_root = str($disk->path(''))
            ->replace(['\\', '//'], '/')
            ->finish('/') // ensure trailing slash
            ->value();

        $target_path = str($disk->path($path))
            ->replace(['\\', '//'], '/')
            ->finish('/') // ensure trailing slash
            ->value();

        // Safety check: ensure target is inside disk root
        if (!str_starts_with($target_path, $disk_root)) {
            // Don't allow operations outside the root
            return;
        }

        // Delete files first - Ensure files are deleted when using Amazon S3 etc.
        foreach ($disk->files($path) as $file) {
            try {
                $this->deleteFile($file);
            } catch (Exception $e) {
                logger()->error("Failed to delete file {$file}: ".$e->getMessage());
            }
        }

        // Then delete subdirectories recursively
        foreach ($disk->directories($path) as $directory) {
            $this->deleteRecursively($directory);
            // Delete the now-empty subdirectory
            try {
                $disk->deleteDirectory($directory);
            } catch (Exception $e) {
                logger()->error("Failed to delete directory {$directory}: ".$e->getMessage());
            }
        }
    }

    protected function deleteFile(string $file): void
    {
        $disk = $this->disk();

        if ($disk->exists($file)) {
            $disk->delete($file);
        }
    }

    public function deleteSelectedFile(string $file): void
    {
        $disk = $this->disk();

        if (str_contains($file, '..') || str_contains($file, '\\')) {
            abort(403, 'Path traversal detected.');
        }

        $file = ltrim($file, '/');

        $disk_root = str($disk->path(''))
            ->replace(['\\', '//'], '/')
            ->finish('/')
            ->value();

        $target_path = str($disk->path($file))
            ->replace(['\\', '//'], '/')
            ->value();

        if (!str_starts_with($target_path, $disk_root)) {
            abort(403, 'File is outside allowed root.');
        }

        if ($disk->exists($file)) {
            $disk->delete($file);

            $this->loadGallery($this->current_path);
        }
    }

    // Select an image and preview it
    public function selectImage($imagePath): void
    {
        $this->selected_image = $imagePath;
    }

    // Go back to the previous folder
    public function goBack(): void
    {
        // Normalize
        $path = rtrim($this->current_path, '/');

        // Get parent directory
        $this->current_path = dirname($path);

        // dirname('foo') => '.' → normalize to root
        if ($this->current_path === '.' || $this->current_path === '') {
            $this->current_path = '/';
        }

        $this->loadGallery($this->current_path);
    }

    protected function scanFile(string $path, int $timeout = 30): bool
    {
        $scanner = config('x-form.disk.virus_scanner_command');

        if (!$scanner) {
            // No scanner configured, skip scan
            return true;
        }

        // Split command into binary + args
        $parts = preg_split('/\s+/', trim($scanner));
        $binary = array_shift($parts);

        // Resolve binary path
        $scanner_path = trim(shell_exec(
            'command -v '.escapeshellarg($binary)
        ));

        if (!$scanner_path) {
            throw new RuntimeException(
                "Virus scanner binary '{$binary}' is configured but not installed on the server."
            );
        }

        // Escape arguments
        $escapedArgs = array_map('escapeshellarg', $parts);

        // Build command with timeout
        $command = implode(' ', array_filter([
            'timeout '.intval($timeout).'s', // <- timeout in seconds
            escapeshellcmd($scanner_path),
            implode(' ', $escapedArgs),
            escapeshellarg($path),
        ]));

        // Execute and capture stderr
        exec($command.' 2>&1', $output, $result);

        if ($result === 0) {
            return true; // clean
        }

        if ($result === 1) {
            return false; // infected
        }

        throw new RuntimeException(
            "Virus scanner '{$scanner}' failed (exit code {$result}):\n".
            implode("\n", (array) $output)
        );
    }

    // Livewire Render Method
    public function render(): View
    {
        return view('x-form::livewire.filemanager');
    }
}
