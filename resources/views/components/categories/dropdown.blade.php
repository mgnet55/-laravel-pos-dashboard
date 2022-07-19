<select class="form-control" name="{{$name}}" aria-label="Category Select">
    <option disabled selected>@lang('fields.category')</option>
    @foreach($categories as $category)
        <option
            value="{{$category->id}}" @selected($selected == $category->id)>{{$category->name[$currentLocale]}}</option>
    @endforeach
</select>
