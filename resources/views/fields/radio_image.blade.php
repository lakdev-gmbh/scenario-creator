@component($typeForm, get_defined_vars())
    <div data-controller="radiobutton">
        <div class="btn-group btn-group-toggle p-0" data-toggle="buttons">

            @foreach($options as $key => $option)
                <label class="btn btn-default @if($active($key, $value)) active @endif"
                       data-action="click->radiobutton#checked"
                       style="width: 200px; height: 200px; background: url('{{ $option }}') no-repeat;background-size: contain;"
                >
                    <input {{ $attributes->except('id') }}
                           @if($active($key, $value)) checked @endif
                           value="{{ $key }}" id="{{ $key }}-{{$id}}"
                    ></label>
            @endforeach
        </div>
    </div>
@endcomponent
