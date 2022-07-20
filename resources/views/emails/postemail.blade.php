@component('mail::message')
# Introduction

The body of your message.

<br>
<hr>
Post Title : {{ $post_data->title }}
<br>
Post description : {{ $post_data->description }}
<br>
<hr>
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
