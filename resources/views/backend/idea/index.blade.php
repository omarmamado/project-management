@extends('layouts.master')

@section('title', 'Ideas for Roadmap: ' . $roadmaps->name)

@section('css')
    <style>
        .idea-card {
            transition: box-shadow 0.2s ease-in-out;
        }

        .idea-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .idea-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>Ideas for Roadmap: {{ $roadmaps->name }}</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="mb-3">
            <a href="{{ route('idea-roadmaps.index') }}" class="btn btn-secondary">&larr; Back to Roadmaps</a>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addIdeaModal">
                + Add New Idea
            </button>
        </div>

        @foreach ($roadmaps->ideas as $idea)
            <div class="p-3 mb-4 card idea-card">
                <h5>
                    {{ $idea->title }}
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $idea->id }}">Upload Image</button>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#commentsModal{{ $idea->id }}">
                        💬 Comments ({{ $idea->comments->count() }})
                    </button>
                </h5>
                <p>{{ $idea->description }}</p>

                @if ($idea->images && $idea->images->count())
                    <div class="row">
                        @foreach ($idea->images as $image)
                            @php
                                $ext = pathinfo($image->image_path, PATHINFO_EXTENSION);
                            @endphp
                            <div class="col-auto mb-2">
                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <img src="{{ asset($image->image_path) }}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;" />
                                @else
                                    <a href="{{ asset($image->image_path) }}" class="btn btn-outline-primary" target="_blank">📄 View File</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="modal fade" id="uploadModal{{ $idea->id }}" tabindex="-1" aria-labelledby="uploadModalLabel{{ $idea->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('ideas.upload.images', $idea->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title" id="uploadModalLabel{{ $idea->id }}">Upload Images for: {{ $idea->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Select Images</label>
                                        <input class="form-control" type="file" name="images[]" multiple required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Upload</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="commentsModal{{ $idea->id }}" tabindex="-1" aria-labelledby="commentsModalLabel{{ $idea->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Comments for: {{ $idea->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div id="comments-{{ $idea->id }}">
                                    @foreach ($idea->comments->where('parent_id', null) as $comment)
                                        @include('backend.idea._comment', ['comment' => $comment])
                                    @endforeach
                                </div>
                                <form class="mt-3 main-comment-form" data-idea="{{ $idea->id }}">
                                    <div class="input-group">
                                       <textarea name="comment" class="form-control" rows="2" ></textarea>

                                        <button class="btn btn-primary" type="submit">Comment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="modal fade" id="addIdeaModal" tabindex="-1" aria-labelledby="addIdeaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" action="{{ route('ideas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idea_roadmap_id" value="{{ $roadmaps->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Idea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Upload Files</label>
                            <input type="file" name="files[]" class="form-control" multiple>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('submit', '.main-comment-form', function(e){
        e.preventDefault();
        let form = $(this);
        let ideaId = form.data('idea');
        let comment = form.find('textarea[name="comment"]').val();

        $.post('/ideas/' + ideaId + '/comments', {
            _token: '{{ csrf_token() }}',
            comment: comment
        }, function(response){
            $('#comments-' + ideaId).prepend(response.html);
            form.find('textarea[name="comment"]').val('');
        });
    });

    $(document).on('click', '.reply-btn', function(){
        let commentId = $(this).data('id');
        $('form.reply-form[data-parent="'+commentId+'"]').removeClass('d-none').find('textarea').focus();
    });

    $(document).on('click', '.cancel-reply', function(){
        $(this).closest('form.reply-form').addClass('d-none').find('textarea').val('');
    });

    $(document).on('submit', '.reply-form', function(e){
        e.preventDefault();
        let form = $(this);
        let ideaId = form.data('idea');
        let parentId = form.find('input[name="parent_id"]').val();
        let comment = form.find('textarea[name="comment"]').val();

        $.post('/ideas/' + ideaId + '/comments', {
            _token: '{{ csrf_token() }}',
            comment: comment,
            parent_id: parentId
        }, function(response){
            $('#comment-' + parentId).append(response.html);
            form.find('textarea[name="comment"]').val('');
            form.addClass('d-none');
        });
    });
</script>
@endsection
