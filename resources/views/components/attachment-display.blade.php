@if(isset($this->detailid->attachment_details['1']['path']) && isset($this->detailid->attachment_details['1']['name']))
    <a href="{{ asset($this->detailid->attachment_details['1']['path']) }}" target="_blank" class="text-blue-500 underline">
        {{ $this->detailid->attachment_details['1']['name'] }}
    </a>
@else 
    <p class="text-gray-500">No attachment available</p>
@endif
