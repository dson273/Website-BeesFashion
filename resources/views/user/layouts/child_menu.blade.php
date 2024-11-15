  @if ($parentCategory->categoryChildrent->count())

          @foreach ($parentCategory->categoryChildrent as $categoryChild)
              <li>
                  <a href="#">{{ $categoryChild->name }}</a>
                  @if ($categoryChild->categoryChildrent->count())
                      @include('user.layouts.child_menu', ['parentCategory' => $categoryChild])
                  @endif
              </li>
          @endforeach
    
  @endif
