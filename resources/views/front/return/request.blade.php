<div class="mb-4">

    <div class="alert alert-info">
        <h5>Return Address</h5>
        <p>{{ $returnAddress }}</p>
        <hr>
        <p>
            Please courier the selected products to the above address.<br>
            <b>Note:</b> Only selected products will be processed for return.
        </p>
    </div>
    <form action="{{ route('front.orders.return-request.post', $order->id) }}" method="post" enctype="multipart/form-data"
        id="returnRequestForm">
        @csrf
        <div class="row">
            <div class="col-md-8 mx-auto">
                {{-- Ref ID --}}
                <div class="form-group mb-3">
                    <label for="reference_id" class="form-label small text-uppercase">Ref ID for courier</label>
                    <input type="text" name="reference_id" id="reference_id"
                        class="form-control @error('reference_id') border border-danger @enderror"
                        value="{{ old('reference_id') }}" placeholder="Enter courier reference ID">
                    <div id="reference_id_error" class="text-danger">
                        @error('reference_id')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- Product Selection --}}
                <div class="form-group mb-3">
                    <label for="product_ids" class="form-label small text-uppercase">Select Products to Return</label>
                    <select name="product_ids[]" id="product_ids" multiple
                        class="form-control @error('product_ids') border border-danger @enderror">
                        @foreach ($order->products as $product)
                            <option value="{{ $product->id }}"
                                {{ collect(old('product_ids'))->contains($product->id) ? 'selected' : '' }}>
                                {{ $product->name }} ({{ $product->pivot->price }} x {{ $product->pivot->quantity }} =
                                ₹{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }})
                            </option>
                        @endforeach
                    </select>
                    <div id="product_ids_error" class="text-danger">
                        @error('product_ids')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- Photo Proof --}}
                <div class="form-group mb-3">
                    <label for="photo_proof" class="form-label small text-uppercase">Photo proof of package</label>
                    <input accept="image/*" type="file" name="photo_proof" id="photo_proof"
                        class="form-control @error('photo_proof') border border-danger @enderror">
                    <div id="photo_proof_error" class="text-danger">
                        @error('photo_proof')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- Return Date --}}
                <div class="form-group mb-3">
                    <label for="return_date_time" class="form-label small text-uppercase">Return Date & Time</label>
                    <input type="datetime-local" name="return_date_time" id="return_date_time"
                        class="form-control @error('return_date_time') border border-danger @enderror"
                        value="{{ old('return_date_time') }}">
                    <div id="return_date_time_error" class="text-danger">
                        @error('return_date_time')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Bank Details</h5>

                {{-- Bank Account Name --}}
                <div class="form-group mb-3">
                    <label class="form-label small text-uppercase">Bank Account Name</label>
                    <input type="text" name="bank_account_name"
                        class="form-control @error('bank_account_name') border border-danger @enderror"
                        value="{{ old('bank_account_name') }}">
                    <div id="bank_account_name_error" class="text-danger">
                        @error('bank_account_name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- IFSC Code --}}
                <div class="form-group mb-3">
                    <label class="form-label small text-uppercase">BSB Number</label>
                    <input type="text" name="bsb_number"
                        class="form-control @error('bsb_number') border border-danger @enderror"
                        value="{{ old('bsb_number') }}">
                    <div id="bsb_number_error" class="text-danger">
                        @error('bsb_number')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- Bank Account Number --}}
                <div class="form-group mb-3">
                    <label class="form-label small text-uppercase">Account No</label>
                    <input type="text" name="account_no"
                        class="form-control @error('account_no') border border-danger @enderror"
                        value="{{ old('account_no') }}">
                    <div id="account_no_error" class="text-danger">
                        @error('account_no')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- Confirm Bank Account Number --}}
                <div class="form-group mb-3">
                    <label class="form-label small text-uppercase">Confirm Account No</label>
                    <input type="text" name="account_no_confirmation"
                        class="form-control @error('account_no_confirmation') border border-danger @enderror"
                        value="{{ old('account_no_confirmation') }}">
                    <div id="account_no_confirmation_error" class="text-danger">
                        @error('account_no_confirmation')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- Account Holder Name --}}
                <div class="form-group mb-3">
                    <label class="form-label small text-uppercase">Account Holder Name</label>
                    <input type="text" name="account_holder_name"
                        class="form-control @error('account_holder_name') border border-danger @enderror"
                        value="{{ old('account_holder_name') }}">
                    <div id="account_holder_name_error" class="text-danger">
                        @error('account_holder_name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- Return Reason --}}
                <div class="form-group mb-3">
                    <label class="form-label small text-uppercase">Return Reason</label>
                    <textarea name="return_reason" class="form-control @error('return_reason') border border-danger @enderror"
                        rows="3">{{ old('return_reason') }}</textarea>
                    <div id="return_reason_error" class="text-danger">
                        @error('return_reason')
                            {{ $message }}
                        @enderror
                    </div>
                </div>


                {{-- Buttons --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-warning btn-lg me-2">Submit Return Request</button>
                    <button type="reset" class="btn btn-secondary btn-lg" id="cancelButton">Cancel</button>
                </div>
            </div>
        </div>
    </form>

</div>
