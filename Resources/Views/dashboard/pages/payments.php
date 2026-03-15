<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h4 class="fw-bold text-dark"><i class="bi bi-shield-lock-fill text-success me-2"></i>Payment Gateway</h4>
            <p class="text-muted small">All payments are securely processed via the Government Electronic Payment Gateway (GePG).</p>
        </div>
        <div class="col-md-4 text-end">
            <img src="/naps/Public/Assets/img/gepg.png" alt="GePG" class="img-fluid" style="max-height: 50px;">
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
    <table class="table table-hover align-middle">
         <thead class="bg-light">
        <tr>
            <th class="ps-4 small">BILL NO</th>
            <th class="small">CONTROL NUMBER</th>
            <th class="small">AMOUNT</th>
            <th class="small">STATUS</th>
            <th class="small text-end pe-4">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($payments as $p): ?>
        <tr>
            <td class="ps-4 fw-bold">#<?= $p['bill_number'] ?></td>
            
            <td id="ctrl-display-<?= $p['id'] ?>">
                <?php if($p['control_number']): ?>
                    <span class="fw-bold text-primary"><?= $p['control_number'] ?></span>
                <?php else: ?>
                    <span class="text-muted fst-italic">Request Control Number</span>
                <?php endif; ?>
            </td>

            <td class="fw-bold"><?= $p['currency'] ?> <?= number_format($p['amount']) ?></td>
            
            <td>
                <span class="badge rounded-pill px-3 py-2 status-badge-<?= $p['id'] ?> <?= $p['status'] == 'Paid' ? 'bg-success' : 'bg-warning text-dark' ?>">
                    <?= $p['status'] ?>
                </span>
            </td>

            <td class="text-end pe-4" id="action-area-<?= $p['id'] ?>">
                <?php if (!$p['control_number']): ?>
                    <button class="btn btn-sm btn-dark" onclick="generateControl(<?= $p['id'] ?>)">
                        Request Control Number
                    </button>
                <?php elseif ($p['status'] == 'Waiting for Payment'): ?>
                    <button class="btn btn-sm btn-primary px-4" data-bs-toggle="modal" data-bs-target="#gepgModal" 
                            onclick="setModalData(<?= $p['id'] ?>, '<?= $p['amount'] ?>', '<?= $p['control_number'] ?>')">
                        Pay Now
                    </button>
                <?php else: ?>
                    <span class="text-success small fw-bold"><i class="bi bi-check-circle-fill"></i> Cleared</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
   </table>
        </div>
    </div>
</div>

<div class="modal fade" id="gepgModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="row g-0">
                <div class="col-md-5 bg-primary text-white p-5 d-flex flex-column justify-content-center text-center">
                    <img src="/naps/public/assets/img/gepg.png" class="bg-white p-2 rounded mx-auto mb-4" width="100">
                    <h5 class="fw-bold">Secured by GePG</h5>
                    <p class="small opacity-75">Your transaction is protected using military-grade encryption. Ensure your mobile device is nearby to confirm the push request.</p>
                </div>
                <div class="col-md-7 p-4 bg-white">
                    <div class="text-end"><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="text-center mb-4">
                        <p class="text-muted small mb-0">Total Payable</p>
                        <h2 class="fw-bold text-dark" id="modal_amt">Tsh 0.00</h2>
                        <div class="badge bg-light text-primary border px-3">CTRL: <span id="modal_ctrl">---</span></div>
                    </div>
                    <form id="paymentConfirmForm">
                        <input type="hidden" id="p_id">
                        <div class="mb-3">
                            <label class="small fw-bold">Mobile Money Number</label>
                            <input type="tel" class="form-control form-control-lg" placeholder="07XXXXXXXX" required>
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold">Wallet PIN</label>
                            <input type="password" class="form-control form-control-lg" placeholder="****" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow">Complete Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function generateControl(id) {
    const actionArea = document.getElementById(`action-area-${id}`);
    const ctrlDisplay = document.getElementById(`ctrl-display-${id}`);
    
    
    const originalContent = actionArea.innerHTML;
    actionArea.innerHTML = '<span class="spinner-border spinner-border-sm text-dark"></span>';

    fetch('/naps/citizen/get-control-no', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({ 'id': id })
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            
            ctrlDisplay.innerHTML = `<span class="fw-bold text-primary animate__animated animate__fadeIn">${data.control_number}</span>`;
            actionArea.innerHTML = `
                <button class="btn btn-sm btn-primary px-4 animate__animated animate__zoomIn" 
                        data-bs-toggle="modal" data-bs-target="#gepgModal" 
                        onclick="setModalData(${id}, '50000', '${data.control_number}')">
                    Pay Now
                </button>`;
        } else {
            alert("Error: " + data.message);
            actionArea.innerHTML = originalContent;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Connection failed. Please try again.");
        actionArea.innerHTML = originalContent;
    });
}
function setModalData(id, amount, ctrl) {
    document.getElementById('p_id').value = id;
    document.getElementById('modal_ctrl').innerText = ctrl;
    const formattedAmount = parseFloat(amount).toLocaleString();
    document.getElementById('modal_amt').innerText = `Tsh ${formattedAmount}`;
}
document.getElementById('paymentConfirmForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = this.querySelector('button[type="submit"]');
    const paymentId = document.getElementById('p_id').value;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Authorizing Push...';

    fetch('/naps/citizen/payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({ 'id': paymentId })
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            
            setTimeout(() => {
                alert("GePG: Payment Successful! Your permit processing will continue.");
                location.reload(); 
            }, 2000);
        } else {
            alert(data.message);
            btn.disabled = false;
            btn.innerHTML = 'Complete Payment';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.disabled = false;
        btn.innerHTML = 'Complete Payment';
    });
});
</script>