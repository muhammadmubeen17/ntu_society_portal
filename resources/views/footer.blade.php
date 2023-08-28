@include(auth()->user()->role . '.control-sidebar')
@include(auth()->user()->role . '.layouts.footer')
@include($module . '::layouts.footer')
