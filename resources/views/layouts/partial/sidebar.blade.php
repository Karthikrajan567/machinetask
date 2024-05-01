
    @can('create manager')
        <a class="btn btn-primary text-white mb-3" href="{{ route('admin.managerview') }}">Project manager</a>
    @endcan
    @can('create user')
    <a class="btn btn-primary text-white mb-3" href="{{ route('userview') }}">Team Members</a>
    @endcan
    @can('create project')
    <a class="btn btn-primary text-white mb-3" href="{{ route('projectview') }}">project deatils</a>
    @endcan
    @can('create task')
    <a class="btn btn-primary text-white mb-3" href="{{ route('taskview') }}">Create task</a>
    @endcan
    @role('member')
    <a class="btn btn-primary text-white mb-3" href="{{ route('member.taskupdateview') }}">update task status</a>
    @endrole

