@if(session()->has('message'))
    <div class="border rounded-xl shadow-md bg-white text-xl text-center p-2 m-auto w-1/2">
        {{ __('message.' . session()->get('message')) }}
    </div>
@endif
