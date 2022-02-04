@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-2 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Notes</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container text-center">
                            @if ($task->status !== 'Cancelled')
                                <form action="{{ route('task.store-notes')}}" method="post" class="form-group" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="input-group mb-4" >
                                            <textarea name="note" placeholder="Type notes here ..." class="form-control" required></textarea>
                                        </div>
                                        <input type="hidden" name="task_id" value="{{$task->id}}">
                                        <button type="submit" class="btn btn-success" id = "modal-save">
                                            <i class="fa fa-save me-1" aria-hidden="true"></i>
                                            Add Note</button>
                                    </div>
                                </form>
                                
                            @endif
                        </div>
                        <hr>
                        @if (count($task_notes))
                            @foreach ( $task_notes as $note)
                                <div class="posts">
                                    <span class="ms-2 me-1 badge bg-pill {{$note->user_id == Auth::id() ? 
                                        'bg-success' : 'bg-info'}} posts "> {{$note->user_id == Auth::id() ? 'You': $note->user->name}}</span>
                                    <small>{{$note->created_at}}</small>
                                    @if ($note->status==='Private')
                                        <span class="fa fa-share float-end me-5" style="cursor: pointer" id="share-button{{$note->id}}" onclick="shareNote('{{$note->id}}')"> share note</span>
                                        <span class="fa fa-check float-end me-5" id="shared-span{{$note->id}}" style="display: none"> note shared</span>
                                    @endif
                                    <div class="ms-3 mb-2">{{$note->note}} </div> 
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <div class="alert alert-info text-center mb-3">
                                <b>No notes added</b>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// share note
function shareNote(id){
    $.ajax({
            method:'POST',
            url: '{{ route('task.share-notes')}}',
            data:{note_id:id, "_token":"{{csrf_token()}}"}
        })
        .done(function(res){
            if (res.status === 'Public') {
                $("#share-button"+res.id).hide()
                $("#shared-span"+res.id).show()
            }else{
                $("#share-button"+res.id).show()
                // $("#status-button"+res.id).text('mark read')
            }
        })
}

</script>

@endsection
