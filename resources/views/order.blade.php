@component($typeForm, get_defined_vars())
{{--    todo: Add jQuery globally--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5sortable/0.13.3/html5sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="alert alert-success rounded shadow-sm mb-3 p-3" style="display:none;" id="{{ 'save-order' }}">

    </div>
    <table class="matrix table" {{ $attributes }}>
        <tbody class="{{ $listClass }}">
        @foreach($editables as $editable)
            <tr data-id="{{ $editable->getKey() }}" data-class="{{ get_class($editable) }}">
                <td><x-orchid-icon path="menu"/> {{ $editable->title }} {{ ($editable instanceof \App\Models\TaskGroupElement)? '(' . ($editable->type  ?? 'infotext') . ')' : ''}}</td>
                <td>
                    <a href="{{ $editable->getEditPath() }}">
                        <button>{{ __('Edit') }}</button>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if($editables->count() !== 0)
        <div>
            <button onclick="updateOrder()">{{__('Save order')}}</button>
        </div>
    @endif
    <script defer>
        $(document).ready(function () {
            sortable('.{{ $listClass }}', {
                forcePlaceholderSize: true,
                itemSerializer: function (item, container) {
                    if (item.node.hasAttribute('data-id')) {
                        item.id = item.node.getAttribute('data-id')
                        item.class = item.node.getAttribute('data-class')
                    }
                    return item
                }
            });
        });

        function updateOrder() {
            let data = {}
            data["{{ $name }}"] = sortable('.{{ $listClass }}', 'serialize')[0].items
            $.ajax({
                url: location.pathname + "/{{ $method }}",
                contentType: "application/json",
                data: JSON.stringify(data),
                method: 'POST',
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').attr('value')
                },
                success: function (data) {
                    let jsonData = JSON.parse(data);
                    $('#{{'save-order'}}')
                        .text(jsonData.message)
                        .fadeIn()
                        .fadeTo(5000,1)
                        .fadeOut();
                },
            });
        }

    </script>
@endcomponent
