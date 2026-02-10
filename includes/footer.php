</div>
</div>
<!-- Chat Toggle Button -->
<div id="chat-toggle">
    <i class="bi bi-chat-dots-fill"></i>
</div>
<!-- Chat Box -->
<div id="chat-box">
    <div class="chat-header">
        <div class="chat-user-select">
            <!-- ROLE -->
            <select id="chat-role">
                <option value="">Select Role</option>
                <option value="doctor">Doctor</option>
                <option value="nurse">Nurse</option>
                <option value="support">Support</option>
            </select>

            <!-- USER -->
            <select id="chat-user" disabled>
                <option value="">Select User</option>
            </select>
        </div>
        <button id="chat-close">&times;</button>
    </div>

    <div class="chat-body" id="chat-body">
        <p class="bot">👋 Please select a user to start chat</p>
    </div>

    <div class="chat-footer">
        <input type="text" id="chat-input" placeholder="Type a message..." disabled>
        <button id="chat-send" disabled>Send</button>
    </div>
</div>

<script>
    // Live Chat code
    document.addEventListener("DOMContentLoaded", function () {
        const chatToggle = document.getElementById("chat-toggle");
        const chatBox = document.getElementById("chat-box");
        const chatClose = document.getElementById("chat-close");
        chatToggle.addEventListener("click", function (e) {
            e.stopPropagation();

            chatBox.classList.toggle("active");

            chatToggle.innerHTML = chatBox.classList.contains("active")
                ? '<i class="bi bi-x-lg"></i>'
                : '<i class="bi bi-chat-dots-fill"></i>';
        });
        chatClose.addEventListener("click", function (e) {
            e.stopPropagation();
            chatBox.classList.remove("active");
            chatToggle.innerHTML = '<i class="bi bi-chat-dots-fill"></i>';
        });
        chatBox.addEventListener("click", function (e) {
            e.stopPropagation();
        });
        document.addEventListener("click", function () {
            chatBox.classList.remove("active");
            chatToggle.innerHTML = '<i class="bi bi-chat-dots-fill"></i>';
        });
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                chatBox.classList.remove("active");
                chatToggle.innerHTML = '<i class="bi bi-chat-dots-fill"></i>';
            }
        });
    });

    // chat user code here
    document.addEventListener("DOMContentLoaded", function () {
        const roleSelect = document.getElementById("chat-role");
        const userSelect = document.getElementById("chat-user");
        const chatBody   = document.getElementById("chat-body");
        const chatInput  = document.getElementById("chat-input");
        const chatSend   = document.getElementById("chat-send");

        const usersByRole = {
            doctor: [
                { id: 1, name: "Dr. Amit" },
                { id: 2, name: "Dr. Rohan" }
            ],
            nurse: [
                { id: 3, name: "Nurse Pooja" },
                { id: 4, name: "Nurse Suman" }
            ],
            support: [
                { id: 5, name: "Support Rahul" }
            ]
        };

        // Role change
        roleSelect.addEventListener("change", function () {

            userSelect.innerHTML = '<option value="">Select User</option>';
            chatInput.disabled = true;
            chatSend.disabled  = true;

            if (this.value === "") {
                userSelect.disabled = true;
                chatBody.innerHTML = `<p class="bot">👋 Please select a role</p>`;
                return;
            }
            // Fill users
            usersByRole[this.value].forEach(user => {
                const option = document.createElement("option");
                option.value = user.id;
                option.textContent = user.name;
                userSelect.appendChild(option);
            });

            userSelect.disabled = false;
            chatBody.innerHTML = `<p class="bot">Select a ${this.value} to start chat</p>`;
        });

        // User change
        userSelect.addEventListener("change", function () {
            if (this.value !== "") {
                chatBody.innerHTML = `<p class="bot">Chat started with <b>${this.options[this.selectedIndex].text}</b></p>`;
                chatInput.disabled = false;
                chatSend.disabled  = false;
                chatInput.focus();
            }
        });
    });
</script>
<!-- jQuery (Sabse pehle) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables Core -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<!-- Export dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<!-- Export buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="<?= BASE_URL ?>js/custom.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#appointmentTable').DataTable({
            paging: true,        
            pageLength: 10,        
            lengthMenu: [10, 25, 50, 100],
            searching: true,       
            lengthChange: true,   
            info: true,           
            ordering: true,

            dom: 'lBrtip',         
            buttons: [
                {
                    extend: 'excel',
                    className: 'd-none',
                    title: 'Appointment List'
                },
                {
                    extend: 'pdf',
                    className: 'd-none',
                    title: 'Appointment List'
                },
                {
                    extend: 'csv',
                    className: 'd-none',
                    title: 'Appointment List'
                },
                {
                    extend: 'print',
                    className: 'd-none',
                    title: 'Appointment List'
                }
            ]
        });
        /* 🔍 External Search Box */
        $('.search-box input').on('keyup', function () {
            table.search(this.value).draw();
        });

        /* 📄 Export Buttons */
        $('.btn-success').on('click', function () {
            table.button('.buttons-excel').trigger();
        });

        $('.btn-danger').on('click', function () {
            table.button('.buttons-pdf').trigger();
        });

        $('.btn-primary').on('click', function () {
            table.button('.buttons-csv').trigger();
        });

        $('.btn-dark').on('click', function () {
            table.button('.buttons-print').trigger();
        });
    });
</script>
</body>
</html>