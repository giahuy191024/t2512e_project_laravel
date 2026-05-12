<!-- Appointment Booking Modal -->
<div id="appointmentModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        
        <div class="booking-container">
            <div class="booking-doctor-info">
                <img id="modalDoctorImage" src="" alt="Bác sĩ" class="doctor-modal-image" />
                <div>
                    <h3 id="modalDoctorName"></h3>
                    <p id="modalDoctorClinic" style="color: #666;">
                        <i class="fas fa-clinic-medical"></i> <span id="clinicName"></span>
                    </p>
                    <p id="modalDoctorAddress" style="color: #999; font-size: 14px;">
                        <i class="fas fa-map-marker-alt"></i> <span id="doctorAddress"></span>
                    </p>
                </div>
            </div>

            <form id="appointmentForm" method="POST">
                @csrf
                <input type="hidden" id="doctorId" name="doctor_id" />

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Họ tên bệnh nhân (bắt buộc)</label>
                    <input type="text" name="patient_name" placeholder="Họ tên bệnh nhân" required />
                </div>

                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Số điện thoại liên hệ (bắt buộc)</label>
                    <input type="tel" name="phone" placeholder="Số điện thoại liên hệ" required />
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Địa chỉ email</label>
                    <input type="email" name="email" placeholder="Địa chỉ email" />
                </div>

                <div class="form-group">
                    <label><i class="fas fa-birthday-cake"></i> Năm sinh (bắt buộc)</label>
                    <input type="number" name="birth_year" placeholder="Năm sinh" min="1900" max="{{ date('Y') }}" required />
                </div>

                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> Ngày khám</label>
                    <input type="date" name="appointment_date" required />
                </div>

                <div class="form-group">
                    <label><i class="fas fa-stethoscope"></i> Lý do khám</label>
                    <textarea name="reason" placeholder="Lý do khám" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label>Bạn biết đến Nha Khoa Trẻ từ đâu?</label>
                    <div class="radio-group">
                        <label><input type="radio" name="source" value="Google" /> Google</label>
                        <label><input type="radio" name="source" value="Facebook" /> Facebook</label>
                        <label><input type="radio" name="source" value="TikTok" /> TikTok</label>
                        <label><input type="radio" name="source" value="Other" /> Khác</label>
                    </div>
                </div>

                <p class="form-note">Quý khách vui lòng điền đầy đủ thông tin trên</p>
                
                <button type="submit" class="btn-submit">Xác nhận đặt khám</button>
            </form>
        </div>
    </div>
</div>

<style>
.modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    position: relative;
}

.close-modal {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    line-height: 20px;
}

.close-modal:hover {
    color: #000;
}

.booking-container {
    margin-top: 20px;
}

.booking-doctor-info {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    padding: 15px;
    background-color: #f5f5f5;
    border-radius: 8px;
}

.doctor-modal-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}

.booking-doctor-info h3 {
    margin: 0 0 5px 0;
    color: #333;
}

.booking-doctor-info p {
    margin: 3px 0;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-family: Arial, sans-serif;
    font-size: 14px;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #0099ff;
    box-shadow: 0 0 0 3px rgba(0, 153, 255, 0.1);
}

.radio-group {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.radio-group label {
    display: flex;
    align-items: center;
    margin: 0;
    font-weight: 400;
}

.radio-group input[type="radio"] {
    width: auto;
    margin-right: 8px;
}

.form-note {
    font-size: 12px;
    color: #999;
    margin: 15px 0;
    text-align: center;
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #ffc107, #ff9800);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #ffb300, #ff8800);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
}

@media (max-width: 768px) {
    .modal-content {
        padding: 20px;
    }

    .booking-doctor-info {
        flex-direction: column;
        text-align: center;
    }

    .doctor-modal-image {
        margin: 0 auto;
    }

    .radio-group {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('appointmentModal');
    const closeBtn = document.querySelector('.close-modal');
    const appointmentForm = document.getElementById('appointmentForm');

    // Close modal
    closeBtn.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    // Open appointment modal
    window.openAppointmentModal = function(doctorId, doctorName, doctorImage, clinicName, doctorAddress) {
        document.getElementById('doctorId').value = doctorId;
        document.getElementById('modalDoctorName').textContent = doctorName;
        document.getElementById('modalDoctorImage').src = doctorImage;
        document.getElementById('clinicName').textContent = clinicName;
        document.getElementById('doctorAddress').textContent = doctorAddress;
        modal.style.display = 'flex';
        // Reset form
        appointmentForm.reset();
    }

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="appointment_date"]').setAttribute('min', today);

    // Handle form submission via AJAX
    appointmentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(appointmentForm);
        
        fetch('/appointment/book', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                modal.style.display = 'none';
                appointmentForm.reset();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        });
    });
});
</script>
