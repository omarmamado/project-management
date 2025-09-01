<div class="p-2 mb-2 border rounded" id="comment-{{ $comment->id }}">
    <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}

    <div class="mt-1">
        <a href="javascript:void(0)" class="reply-btn text-primary" data-id="{{ $comment->id }}" data-idea="{{ $comment->idea_id }}">
            💬 Reply
        </a>
    </div>

    <!-- فورم الرد -->
    <form class="mt-2 reply-form d-none" data-parent="{{ $comment->id }}" data-idea="{{ $comment->idea_id }}">
        @csrf
        <div class="input-group">
            <textarea name="comment" class="form-control form-control-sm" rows="2" placeholder="Write a reply..."></textarea>
            <div class="">
                
            </div>
            <button type="submit" class="btn btn-sm btn-success">Send</button>
            <button type="button" class="btn btn-sm btn-secondary cancel-reply">Cancel</button>
        </div>
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
    </form>

    <!-- الردود -->
    <div class="mt-2 ms-4">
        @foreach($comment->replies as $reply)
            @include('backend.idea._comment', ['comment' => $reply])
        @endforeach
    </div>
</div>
