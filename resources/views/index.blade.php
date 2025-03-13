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
                  <div class="service-option selected" data-service="Rental PS 4">
                      <h3>Rental PS 4</h3>
                  </div>
                  <div class="service-option" data-service="Rental PS 5">
                      <h3>Rental PS 5</h3>
                  </div>
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
      let selectedService = "Rental PS 4"; 
      function selectService(service) {
          selectedService = service;
          document.querySelectorAll('.service-option').forEach(el => el.classList.remove('selected'));
          document.querySelector(`[data-service="${service}"]`).classList.add('selected');
          renderCalendar();
      }
      document.querySelectorAll('.service-option').forEach(el => {
          el.addEventListener('click', () => selectService(el.dataset.service));
      });

      const calendarDays = document.getElementById('calendar-days');
      const currentMonthDisplay = document.getElementById('current-month');
      const prevMonthBtn = document.getElementById('prev-month');
      const nextMonthBtn = document.getElementById('next-month');
      
      let currentDate = new Date();
      let currentMonth = currentDate.getMonth();
      let currentYear = currentDate.getFullYear();
      let selectedDate = null;

      const availableDates = {}; 
      for (let m = 0; m < 12; m++) {
          const tempDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + m, 1);
          const year = tempDate.getFullYear();
          const month = tempDate.getMonth();
          const daysInMonth = new Date(year, month + 1, 0).getDate();

          for (let d = 1; d <= daysInMonth; d++) {
              const dateObj = new Date(year, month, d);
              const today = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

              if (dateObj >= today) { 
                  const dateKey = `${year}-${month + 1}-${d}`;
                  availableDates[dateKey] = {
                      "Rental PS 4": ["Sesi 1", "Sesi 2", "Sesi 3"],
                      "Rental PS 5": ["Sesi 1", "Sesi 2", "Sesi 3"]
                  };
              }
          }
      }

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
              } else if (availableDates[dateKey] && availableDates[dateKey][selectedService]) {
                  const remainingSessions = availableDates[dateKey][selectedService].length;
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
              
              modalTitle.innerHTML = `${selectedService} <p style="font-size: 18px; font-weight: normal;">${selectedDate.toLocaleDateString('id-ID', { 
                  weekday: 'long', 
                  day: 'numeric', 
                  month: 'long', 
                  year: 'numeric' 
              })}</p>`;

              if (!availableDates[dateKey][selectedService] || availableDates[dateKey][selectedService].length === 0) {
                  modalBody.innerHTML = "<p>Sesi penuh</p>";
              } else {
                  availableDates[dateKey][selectedService].forEach((session) => {
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

          function showStep2(selectedSession) {
              step1.style.display = "none";
              step2.style.display = "block";
              selectedSessionText.innerHTML = `
                  ${selectedService} - ${selectedSession} <br> ${selectedDate}
              `;

              const basePrice = selectedService === "Rental PS 4" ? 30000 : 40000; // get from db
              const dayOfWeek = selectedDate.getDay();
              const weekendSurcharge = (dayOfWeek === 0 || dayOfWeek === 6) ? 50000 : 0;
              const total = basePrice + weekendSurcharge

              $('#base-price').text(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(basePrice))
              $('#weekend-surcharge').text(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(weekendSurcharge))
              $('#total').text(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total))
          }

          backButton.addEventListener('click', showStep1);

          confirmButton.addEventListener('click', function() {
              console.log("Get midtrans url and redirect");
              window.location.href = "https://www.google.com";
              modal.style.display = "none";
          });

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
  });
</script>
@endpush