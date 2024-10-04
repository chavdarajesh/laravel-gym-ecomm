@if (!empty($data))
            <a href="{{ route('admin.newslettermails.view', ['id' => $data['id']]) }}"> <button type="button"
                    class="btn btn-icon btn-outline-info">
                    <i class="bx bx-show"></i>
                </button>
            </a>

            <a href="{{ route('admin.newslettermails.edit', ['id' => $data['id']]) }}"> <button type="button"
                    class="btn btn-icon btn-outline-warning">
                    <i class="bx bxs-edit"></i>
                </button>
            </a>

            <button type="button" class="btn btn-icon btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#delete-modal-{{ $data['id'] }}">
                <i class="bx bx-trash-alt"></i>
            </button>
            <div class="modal fade" id="delete-modal-{{ $data['id'] }}" tabindex="-1" style="display: none;"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form action="{{ route('admin.newslettermails.delete', ['id' => $data['id']]) }}" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Delete Item
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h3>Do You Want To Really Delete This Item?</h3>
                                @csrf
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                    </form>
                </div>
            </div>

@endif
