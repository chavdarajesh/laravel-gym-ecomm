@extends('admin.layouts.main')
@section('title', 'View NewsletterMail')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">NewsletterMails /</span> All NewsletterMails /</span>
        View NewsletterMail</h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h5 class="card-header">NewsletterMails Setting</h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="email" class="form-label">Emails</label>
                            <div>

                                <div class="d-inline">
                                    @if(!$NewsletterContent->mails->isEmpty())
                                    @foreach ($NewsletterContent->mails as $mail)
                                    <div class="d-inline mb-1">
                                        <input class="form-control" type="text" disabled id="email"
                                        name="email" value="{{ $mail->email }}" />
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="d-inline mb-1">
                                    <input class="form-control" type="text" disabled id="email"
                                        name="email" value=" No Emails Found!!" />
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="content" class="form-label">Content</label>
                            <div class="form-control">
                                {!! $NewsletterContent['content'] !!}
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('admin.newslettermails.sendmail', $NewsletterContent->id) }}" class="btn btn-success">Send Email</a>
                            <a href="{{ route('admin.newslettermails.edit', $NewsletterContent->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('admin.newslettermails.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
@stop
