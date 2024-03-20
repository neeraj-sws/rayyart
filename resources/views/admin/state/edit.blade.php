<div class="card">
    <div class="card-body">
        <div class="modal-header">
            <h4 class="modal-title">Edit {{ $single_heading }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-3">
            <form class="row g-3" action="{{ $route->store }}"
                onsubmit="event.preventDefault();form_submit(this);return false;" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$info->id}}">
      
                <div class="col-md-6">
                    <label for="title" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$info->state_title}}">
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="1" @if ($info->status == 1) selected @endif> Active </option>
                        <option value="0" @if ($info->status == 0) selected @endif> Inactive </option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary float-end">Update <i
                            class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>