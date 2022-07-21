<select class="form-control" name="{{$name}}" aria-label="Category Select">
    <option selected value>-- @lang('site.categories') --</option>
    @foreach($categories as $category)
        <option
            value="{{$category->id}}" @selected($selected == $category->id)>{{$category->name[$currentLocale]}}</option>
    @endforeach
</select>
