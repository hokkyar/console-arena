@extends('layouts.app')

@section('content')
  @include('components.modal')
  <div class="container">
      <header>
          <h1>{{ config('app.name') }}</h1>
          <p>Platform booking rental PS4 dan PS5 yang mudah dan cepat!</p>
      </header>
      <div class="booking-system">
          <div class="time-section">
              <h2>Pilih Layanan</h2>
              <div class="services">
                @foreach ($services as $service)
                    <div class="service-option {{ $loop->first ? 'selected' : '' }}" data-service-id="{{ $service->id }}" data-service="{{ json_encode($service) }}">
                      <h3>{{ $service->name }}</h3>
                  </div>
                @endforeach
              </div>
          </div>
          <div class="calendar-section">
              <div class="calendar-header">
                  <h2 id="current-month"></h2>
                  <div class="calendar-nav">
                      <button id="prev-month">&lt;</button>
                      <button id="next-month">&gt;</button>
                  </div>
              </div>
              <div class="calendar-grid" id="calendar-days-header">
                  <div class="calendar-day-header">Min</div>
                  <div class="calendar-day-header">Sen</div>
                  <div class="calendar-day-header">Sel</div>
                  <div class="calendar-day-header">Rab</div>
                  <div class="calendar-day-header">Kam</div>
                  <div class="calendar-day-header">Jum</div>
                  <div class="calendar-day-header">Sab</div>
              </div>
              <div class="calendar-grid" id="calendar-days"></div>
          </div>
      </div>
  </div>
@endsection

@push('scripts')
<script type="module">
  document.addEventListener('DOMContentLoaded', function() {
      const serviceOptions = document.querySelectorAll('.service-option');
      let selectedService = serviceOptions.length > 0 ? JSON.parse(serviceOptions[0].dataset.service) : null;

      function selectService(service, serviceId) {
          selectedService = JSON.parse(service);
          document.querySelectorAll('.service-option').forEach(el => el.classList.remove('selected'));
          document.querySelector(`[data-service-id="${serviceId}"]`).classList.add('selected')
          renderCalendar();
      }

      if (serviceOptions.length == 0) {
          console.warn("Empty services.");
          document.querySelector('.booking-system').innerHTML = "<p class='no-services'>Belum ada layanan yang tersedia.</p>";
          return
      }

      serviceOptions.forEach(el => {
          el.addEventListener('click', () => selectService(el.dataset.service, el.dataset.serviceId));
      });

      const calendarDays = document.getElementById('calendar-days');
      const currentMonthDisplay = document.getElementById('current-month');
      const prevMonthBtn = document.getElementById('prev-month');
      const nextMonthBtn = document.getElementById('next-month');
      
      let currentDate = new Date();
      let currentMonth = currentDate.getMonth();
      let currentYear = currentDate.getFullYear();
      let selectedDate = null;
      let selectedSession = null;

      const availableDates = @json($availableDates); 

      function renderCalendar() {
          calendarDays.innerHTML = '';

          const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
          const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

          currentMonthDisplay.textContent = new Date(currentYear, currentMonth).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });

          prevMonthBtn.disabled = currentYear === currentDate.getFullYear() && currentMonth <= currentDate.getMonth();

          for (let i = 0; i < firstDayOfMonth; i++) {
              const dayEl = document.createElement('div');
              dayEl.classList.add('calendar-day', 'unavailable');
              calendarDays.appendChild(dayEl);
          }

          for (let i = 1; i <= daysInMonth; i++) {
              const dayEl = document.createElement('div');
              dayEl.classList.add('calendar-day');
              dayEl.textContent = i;

              const dateKey = `${currentYear}-${currentMonth + 1}-${i}`;
              const isPast = new Date(currentYear, currentMonth, i) < new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

              if (isPast) {
                  dayEl.classList.add('unavailable');
              } else if (availableDates[dateKey] && availableDates[dateKey][selectedService.id]) {
                  const remainingSessions = availableDates[dateKey][selectedService.id].length;
                  const indicator = document.createElement('div');
                  indicator.classList.add('availability-indicator');

                  indicator.textContent = remainingSessions > 0 ? `${remainingSessions} Sesi tersedia` : "Sesi penuh";
                  if (remainingSessions === 0) dayEl.classList.add('unavailable');

                  dayEl.appendChild(indicator);

                  dayEl.addEventListener('click', function() {
                      if (remainingSessions === 0) return;

                      document.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected'));
                      dayEl.classList.add('selected');

                      selectedDate = new Date(currentYear, currentMonth, i);
                      renderTimeSlots(dateKey);
                  });
              } else {
                  dayEl.classList.add('unavailable');
              }

              calendarDays.appendChild(dayEl);
          }
      }

      function renderTimeSlots(dateKey) {
          const modal = document.getElementById('timeSlotModal');
          const modalBody = document.getElementById('modal-body');
          const modalTitle = document.getElementById('modal-title');
          const closeModal = document.querySelector('.close');
          
          const step1 = document.getElementById('step1');
          const step2 = document.getElementById('step2');
          const selectedSessionText = document.getElementById('selected-session');
          const backButton = document.getElementById('back-btn');
          const confirmButton = document.getElementById('confirm-btn');

          function showStep1() {
              step1.style.display = "block";
              step2.style.display = "none";
              modalBody.innerHTML = '';
              
              modalTitle.innerHTML = `${selectedService.name} <p style="font-size: 18px; font-weight: normal;">${selectedDate.toLocaleDateString('id-ID', { 
                  weekday: 'long', 
                  day: 'numeric', 
                  month: 'long', 
                  year: 'numeric' 
              })}</p>`;

              if (!availableDates[dateKey][selectedService.id] || availableDates[dateKey][selectedService.id].length === 0) {
                  modalBody.innerHTML = "<p>Sesi penuh</p>";
              } else {
                  availableDates[dateKey][selectedService.id].forEach((session) => {
                      const slot = document.createElement('div');
                      slot.classList.add('time-slot');
                      slot.textContent = session;

                      slot.addEventListener('click', function() {
                          showStep2(session);
                      });

                      modalBody.appendChild(slot);
                  });
              }
          }

          function showStep2(session) {
              step1.style.display = "none";
              step2.style.display = "block";
              selectedSession = session
              selectedSessionText.innerHTML = `
                  ${selectedDate.toLocaleDateString('id-ID', {
                      weekday: 'long',
                      day: 'numeric',
                      month: 'long',
                      year: 'numeric'
                  })}
              <br> ${selectedService.name} - ${session}`;

              const basePrice = selectedService.base_price
              const dayOfWeek = selectedDate.getDay();
              const weekendSurcharge = (dayOfWeek === 0 || dayOfWeek === 6) ? 50000 : 0;
              const total = parseInt(basePrice) + weekendSurcharge

              $('#base-price').text(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(basePrice))
              $('#weekend-surcharge').text(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(weekendSurcharge))
              $('#total').text(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total))
          }

          backButton.addEventListener('click', showStep1);
          confirmButton.addEventListener('click', handleConfirm);

          modal.style.display = "flex";
          showStep1();

          closeModal.onclick = function() {
              modal.style.display = "none";
          };

          window.onclick = function(event) {
              if (event.target == modal) {
                  modal.style.display = "none";
              }
          };
      }

      function handleConfirm() {
        const date = `${selectedDate.getFullYear()}-${(selectedDate.getMonth() + 1).toString().padStart(2, '0')}-${selectedDate.getDate().toString().padStart(2, '0')}`;
        bookSession(selectedService.id, date, selectedSession);
      }

      prevMonthBtn.addEventListener('click', function() {
          if (currentYear === currentDate.getFullYear() && currentMonth <= currentDate.getMonth()) {
              return;
          }

          currentMonth--;
          if (currentMonth < 0) {
              currentMonth = 11;
              currentYear--;
          }
          renderCalendar();
      });

      nextMonthBtn.addEventListener('click', function() {
          currentMonth++;
          if (currentMonth > 11) {
              currentMonth = 0;
              currentYear++;
          }
          renderCalendar();
      });

      renderCalendar();

      function bookSession(serviceId, date, session) {
          isLoading(true)

          fetch('/', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
              },
              body: JSON.stringify({
                  service_id: serviceId,
                  booking_date: date,
                  session: session,
                  customer_name: $('#customer_name').val(),
                  customer_email: $('#customer_email').val(),
                  customer_phone: $('#customer_phone').val(),
              })
          })
          .then(response => response.json())
          .then(data => {
              isLoading(false)
              if (data.errors) {
                showErrors(data.errors);
                return
              }

              window.onclick = null;
              $('.close').hide()
              $('#step2').hide()
              $('#snap-container').show()
              snap.embed(data.snap_token, { 
                embedId: 'snap-container',
              })
          })
          .catch(error => {
            isLoading(false)
            $('#error-message').show()
          });
      }

      function showErrors(errors) {
        Object.keys(errors).forEach((key) => {
            const input = document.getElementById(key);
            const formGroup = input.parentElement;
            const errorMessage = formGroup.querySelector(".error-input");
            errorMessage.innerText = errors[key][0]; 
            formGroup.classList.add("error"); 
        });
      }

      function isLoading(loadingState) {
        if (loadingState) {
          $('#confirm-btn').prop('disabled', true)
          $('#back-btn').prop('disabled', true)
          $('#confirm-btn').text('Loading...')
        } else {
          $('#confirm-btn').prop('disabled', false)
          $('#back-btn').prop('disabled', false)
          $('#confirm-btn').text('Lanjut Pembayaran')
        }
      }

      document.querySelectorAll(".input-field").forEach((input) => {
          input.addEventListener("input", function () {
              const formGroup = this.parentElement;
              formGroup.classList.remove("error");
              formGroup.querySelector(".error-input").innerText = "";
          });
      });

  });
</script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endpush