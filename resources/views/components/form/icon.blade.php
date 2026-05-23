@props([
    'name',
    'class' => 'size-5'
])

@switch($name)
    @case('paragraph')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M360-160v-240q-83 0-141.5-58.5T160-600q0-83 58.5-141.5T360-800h360v80h-80v560h-80v-560H440v560h-80Z" />
        </svg>
        @break

    @case('headings')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M420-160v-520H200v-120h560v120H540v520H420Z" />
        </svg>
        @break

    @case('textcase')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="m131-252 165-440h79l165 440h-76l-39-112H247l-40 112h-76Zm139-176h131l-64-182h-4l-63 182Zm395 186q-51 0-81-27.5T554-342q0-44 34.5-72.5T677-443q23 0 45 4t38 11v-12q0-29-20.5-47T685-505q-23 0-42 9.5T610-468l-47-35q24-29 54.5-43t68.5-14q69 0 103 32.5t34 97.5v178h-63v-37h-4q-14 23-38 35t-53 12Zm12-54q35 0 59.5-24t24.5-56q-14-8-33.5-12.5T689-393q-32 0-50 14t-18 37q0 20 16 33t40 13Z" />
        </svg>
        @break

    @case('fontsize')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M280-160v-520H80v-120h520v120H400v520H280Zm360 0v-320H520v-120h360v120H760v320H640Z" />
        </svg>
        @break

    @case('bold')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M272-200v-560h221q65 0 120 40t55 111q0 51-23 78.5T602-491q25 11 55.5 41t30.5 90q0 89-65 124.5T501-200H272Zm121-112h104q48 0 58.5-24.5T566-372q0-11-10.5-35.5T494-432H393v120Zm0-228h93q33 0 48-17t15-38q0-24-17-39t-44-15h-95v109Z" />
        </svg>
        @break

    @case('italic')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M200-200v-100h160l120-360H320v-100h400v100H580L460-300h140v100H200Z" />
        </svg>
        @break

    @case('underline')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M200-120v-80h560v80H200Zm280-160q-101 0-157-63t-56-167v-330h103v336q0 56 28 91t82 35q54 0 82-35t28-91v-336h103v330q0 104-56 167t-157 63Z" />
        </svg>
        @break

    @case('strikethrough')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M80-400v-80h800v80H80Zm340-160v-120H200v-120h560v120H540v120H420Zm0 400v-160h120v160H420Z" />
        </svg>
        @break

    @case('superscript')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M760-600v-80q0-17 11.5-28.5T800-720h80v-40H760v-40h120q17 0 28.5 11.5T920-760v40q0 17-11.5 28.5T880-680h-80v40h120v40H760ZM235-160l185-291-172-269h106l124 200h4l123-200h107L539-451l186 291H618L482-377h-4L342-160H235Z" />
        </svg>
        @break

    @case('subscript')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M760-160v-80q0-17 11.5-28.5T800-280h80v-40H760v-40h120q17 0 28.5 11.5T920-320v40q0 17-11.5 28.5T880-240h-80v40h120v40H760Zm-525-80 185-291-172-269h106l124 200h4l123-200h107L539-531l186 291H618L482-457h-4L342-240H235Z" />
        </svg>
        @break

    @case('code')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="m384-336 56-57-87-87 87-87-56-57-144 144 144 144Zm192 0 144-144-144-144-56 57 87 87-87 87 56 57ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
        </svg>
        @break

    @case('textcolor')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M80 0v-160h800V0H80Zm140-280 210-560h100l210 560h-96l-50-144H368l-52 144h-96Zm176-224h168l-82-232h-4l-82 232Z" />
        </svg>
        @break

    @case('backgroundcolor')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="m247-904 57-56 343 343q23 23 23 57t-23 57L457-313q-23 23-57 23t-57-23L153-503q-23-23-23-57t23-57l190-191-96-96Zm153 153L209-560h382L400-751Zm360 471q-33 0-56.5-23.5T680-360q0-21 12.5-45t27.5-45q9-12 19-25t21-25q11 12 21 25t19 25q15 21 27.5 45t12.5 45q0 33-23.5 56.5T760-280ZM80 0v-160h800V0H80Z" />
        </svg>
        @break

    @case('alignment')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M160-200v-80h400v80H160Zm0-160v-80h640v80H160Zm0-160v-80h640v80H160Zm0-160v-80h640v80H160Z" />
        </svg>
        @break

    @case('alignleft')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M120-120v-80h720v80H120Zm0-160v-80h480v80H120Zm0-160v-80h720v80H120Zm0-160v-80h480v80H120Zm0-160v-80h720v80H120Z" />
        </svg>
        @break

    @case('aligncenter')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M120-120v-80h720v80H120Zm160-160v-80h400v80H280ZM120-440v-80h720v80H120Zm160-160v-80h400v80H280ZM120-760v-80h720v80H120Z" />
        </svg>
        @break

    @case('alignright')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M120-760v-80h720v80H120Zm240 160v-80h480v80H360ZM120-440v-80h720v80H120Zm240 160v-80h480v80H360ZM120-120v-80h720v80H120Z" />
        </svg>
        @break

    @case('ul')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M360-200v-80h480v80H360Zm0-240v-80h480v80H360Zm0-240v-80h480v80H360ZM200-160q-33 0-56.5-23.5T120-240q0-33 23.5-56.5T200-320q33 0 56.5 23.5T280-240q0 33-23.5 56.5T200-160Zm0-240q-33 0-56.5-23.5T120-480q0-33 23.5-56.5T200-560q33 0 56.5 23.5T280-480q0 33-23.5 56.5T200-400Zm0-240q-33 0-56.5-23.5T120-720q0-33 23.5-56.5T200-800q33 0 56.5 23.5T280-720q0 33-23.5 56.5T200-640Z" />
        </svg>
        @break

    @case('ol')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M120-80v-60h100v-30h-60v-60h60v-30H120v-60h120q17 0 28.5 11.5T280-280v40q0 17-11.5 28.5T240-200q17 0 28.5 11.5T280-160v40q0 17-11.5 28.5T240-80H120Zm0-280v-110q0-17 11.5-28.5T160-510h60v-30H120v-60h120q17 0 28.5 11.5T280-560v70q0 17-11.5 28.5T240-450h-60v30h100v60H120Zm60-280v-180h-60v-60h120v240h-60Zm180 440v-80h480v80H360Zm0-240v-80h480v80H360Zm0-240v-80h480v80H360Z" />
        </svg>
        @break

    @case('letter_list')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M11 6h9" />
            <path d="M11 12h9" />
            <path d="M11 18h9" />
            <path d="M4 10v-4.5a1.5 1.5 0 0 1 3 0v4.5" />
            <path d="M4 8h3" />
            <path d="M4 20h1.5a1.5 1.5 0 0 0 0 -3h-1.5h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6z" />
        </svg>
        @break

    @case('table')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm240-240H200v160h240v-160Zm80 0v160h240v-160H520Zm-80-80v-160H200v160h240Zm80 0h240v-160H520v160ZM200-680h560v-80H200v80Z" />
        </svg>
        @break

    @case('link')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M680-160v-120H560v-80h120v-120h80v120h120v80H760v120h-80ZM440-280H280q-83 0-141.5-58.5T80-480q0-83 58.5-141.5T280-680h160v80H280q-50 0-85 35t-35 85q0 50 35 85t85 35h160v80ZM320-440v-80h320v80H320Zm560-40h-80q0-50-35-85t-85-35H520v-80h160q83 0 141.5 58.5T880-480Z" />
        </svg>
        @break

    @case('video')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5" />
            <rect x="2" y="6" width="14" height="12" rx="2" />
        </svg>
        @break

    @case('image')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm40-80h480L570-480 450-320l-90-120-120 160Zm-40 80v-560 560Z" />
        </svg>
        @break

    @case('cleanup')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" viewBox="0 -960 960 960" fill="currentColor">
            <path d="m528-546-93-93-121-121h486v120H568l-40 94ZM792-56 460-388l-80 188H249l119-280L56-792l56-56 736 736-56 56Z" />
        </svg>
        @break
@endswitch
