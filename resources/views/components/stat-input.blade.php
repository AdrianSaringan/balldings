@props(['label' => '', 'name' => '', 'value' => null])
<div>
  <label class="block text-xs text-gray-600">{{ $label }}</label>
  <input type="number" min="0" name="{{ $name }}" value="{{ old($name, $value) }}" class="mt-1 w-full border-gray-300 rounded-md" />
</div>
