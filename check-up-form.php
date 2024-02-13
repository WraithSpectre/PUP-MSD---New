

<head>
  <link rel="stylesheet" href="check-up-form.css">
</head>
    <section class="container">
      <header>Check Up Form</header>
      <form action="#" class="form">
        <div class="input-box">
          <label>Full Name</label>
          <input type="text" placeholder="Enter full name" required />
        </div>

        <div class="input-box">
          <label for="student-no">Student No.</label>
          <input type="text" placeholder="Enter Student Number" required>
        </div>

        <div class="input-box">
          <label>Course, Year & Section</label>
          <input type="text" placeholder="Enter Course, Year & Section" required />
        </div>

        <div class="input-box">
          <label>Clinic Physician</label>
          <input type="text" placeholder="Enter Clinic Physician" required />
        </div>

        

        <div class="column">
          <div class="input-box">
            <label>Phone Number</label>
            <input type="number" placeholder="Enter phone number" required />
          </div>
          <div class="input-box">
            <label>Date of Visit</label>
            <input type="date" placeholder="Enter birth date" required />
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Time In</label>
            <input type="time" placeholder="Enter phone number" required />
          </div>
          <div class="input-box">
            <label>Time Out</label>
            <input type="time" placeholder="Enter birth date" required />
          </div>
        </div>

        <div class="column">
          <div class="gender-box">
            <h3>Patient Type</h3>
            <div class="gender-option">
              <div class="gender">
                <input type="radio" id="check-male" name="gender" checked />
                <label for="check-male">New Patient</label>
              </div>
              <div class="gender">
                <input type="radio" id="check-female" name="gender" />
                <label for="check-female">Existing Patient</label>
              </div>
            </div>
          </div>
  
          <div class="gender-box">
            <h3>Gender</h3>
            <div class="gender-option">
              <div class="gender">
                <input type="radio" id="check-male" name="gender" checked />
                <label for="check-male">male</label>
              </div>
              
              <div class="gender">
                <input type="radio" id="check-female" name="gender" />
                <label for="check-female">Female</label>
              </div>
            </div>
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Temperature</label>
            <input type="text" placeholder="" required />
          </div>
          <div class="input-box">
            <label>Pulse</label>
            <input type="text" placeholder="" required />
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Blood Pressure</label>
            <input type="text" placeholder="" required />
          </div>
          <div class="input-box">
            <label>Respiratory Rate</label>
            <input type="text" placeholder="" required />
          </div>
        </div>

        <div class="input-box">
          <label for="follow-up-reason">Complaint/s</label>
          <textarea id="follow-up-reason" name="follow-up-reason" required></textarea>
        </div>

        <div class="input-box">
          <label for="follow-up-reason">Treatment</label>
          <textarea id="follow-up-reason" name="follow-up-reason" required></textarea>
        </div>
        
        <div class="input-box">
          <label for="follow-up-reason">Medications</label>
          <textarea id="follow-up-reason" name="follow-up-reason" required></textarea>
        </div>

        <div class="input-box">
          <label for="follow-up-reason">Reason/s for Follow Up</label>
          <textarea id="follow-up-reason" name="follow-up-reason" required></textarea>
        </div>

        <button>Submit</button>
      </form>
    </section>
