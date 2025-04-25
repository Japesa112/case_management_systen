<!-- resources/views/modals/view_appeal.blade.php -->

<!-- View Appeal Modal -->
<div class="modal fade" id="viewAppealModal" tabindex="-1" aria-labelledby="viewAppealModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAppealModalLabel">Appeal Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="appeal-content">
                    <div class="text-center p-4">
                        <i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '.view-appeal', function () {
            let appealId = $(this).data('id');
            $('#viewAppealModal').modal('show');
            $('#appeal-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            $.ajax({
                url: "{{ route('appeals.show', ':id') }}".replace(':id', appealId),
                type: "GET",
                success: function (response) {
                    let appeal = response.appeal;
                    let attachments = response.attachments;
                    let case_name = response.case_name;

                    let content = `
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                                <strong>Next Hearing Date:</strong> ${appeal.next_hearing_date ?? 'N/A'}<br>
                                <strong>Next Hearing Time:</strong> ${appeal.next_hearing_time ?? 'N/A'}<br>
                                <strong>Appeal Comments:</strong> <p>${appeal.appeal_comments ?? 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Created At:</strong> ${appeal.created_at ?? 'N/A'}<br>
                                <strong>Updated At:</strong> ${appeal.updated_at ?? 'N/A'}<br>
                            </div>
                        </div>
                        <hr>
                        <h5>Attachments</h5>
                        <ul class="list-group">
                    `;

                    if (attachments.length > 0) {
                        attachments.forEach(file => {
                            content += `
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="${file.file_path}" target="_blank">${file.file_name}</a>
                                    <span class="badge bg-primary">${file.file_type ?? 'Unknown'}</span>
                                </li>
                            `;
                        });
                    } else {
                        content += `<li class="list-group-item text-muted">No attachments found.</li>`;
                    }

                    content += `</ul>`;
                    $('#appeal-content').html(content);
                },
                error: function () {
                    $('#appeal-content').html('<div class="text-danger text-center">Error loading appeal details.</div>');
                }
            });
        });
    });
</script>
@endpush
