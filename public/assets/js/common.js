$(document).ready(function () {
    // Add Ticket Row
    $('#addTicketButton').click(function () {
        const ticketRow = `
            <div class="ticket-row mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="ticketType[]" class="form-label">Ticket Type</label>
                        <select class="form-control" name="ticketType[]" required>
                            <option value="Early Bird">Early Bird</option>
                            <option value="Regular">Regular</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="ticketPrice[]" class="form-label">Price</label>
                        <input type="number" class="form-control" name="ticketPrice[]" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ticketQuantity[]" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="ticketQuantity[]" min="0" required>
                    </div>
                </div>
            </div>`;
        $('#ticketContainer').append(ticketRow);
    });
});
