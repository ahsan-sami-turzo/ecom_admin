@foreach ($childs as $childCategory)

    <option value="{{ $childCategory->id }}"  {{ $childCategory->id == 1  ? 'selected' : '' }}><?= str_repeat('-', $childCategory->level * 1) ?> {{ $childCategory->category_name  }}</option>
    @if(count($childCategory->parentCategory))
        @include('admin.category.include.subcategory',['childs' => $childCategory->parentCategory])
    @endif
@endforeach
