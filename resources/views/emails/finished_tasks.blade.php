@component('mail::message')
<div>{{ __('mail.finished_tasks', ['name' => $name, 'task_num' => $task_num]) }}</div>
@endcomponent