@foreach ($childs as $childCategory)
    <option value="{{ $childCategory->id}}" {{ $childCategory->id == $category->parent_category_id ? 'selected' : '' }}><?= str_repeat('&nbsp;', $childCategory->level * 2) ?> {{ $childCategory->category_name }}</option>
    @if(count($childCategory->parentCategory))
        @include('admin.category.include.subcategory',['childs' => $childCategory->parentCategory])
    @endif
@endforeach
