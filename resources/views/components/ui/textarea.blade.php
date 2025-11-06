@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'required' => false,
    'error' => null,
    'success' => null,
    'help' => null,
    'disabled' => false,
    'rows' => 4,
])

@php
    $inputId = $id ?? ($name ? str_replace(['[', ']'], ['-', ''], $name) : 'textarea-' . uniqid());
    $classes = 'textarea';
    if ($error) {
        $classes .= ' error';
    }
    if ($success) {
        $classes .= ' success';
    }
@endphp

<div class="form-group">
    @if($label)
        <label for="{{ $inputId }}" class="label {{ $required ? 'label-required' : '' }}">
            {{ $label }}
        </label>
    @endif
    
    <textarea
        name="{{ $name }}"
        id="{{ $inputId }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >{{ $slot }}</textarea>
    
    @if($help && !$error && !$success)
        <p class="help-text">{{ $help }}</p>
    @endif
    
    @if($error)
        <p class="help-text error">{{ $error }}</p>
    @endif
    
    @if($success)
        <p class="help-text success">{{ $success }}</p>
    @endif
</div>

