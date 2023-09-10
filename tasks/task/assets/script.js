import 'bootstrap/dist/css/bootstrap.min.css';
import './style.css';

import 'jquery';
import 'bootstrap';

var idsCheckedUsers = [];
//validation user
window.validation = (form) => {
  function removeError(input) {
    const parent = input.parentNode;

    if (parent.classList.contains('error')) {
      parent.querySelector('.error-label').remove();
      parent.classList.remove('error');
    }
  }

  function createError(input, text) {
    const parent = input.parentNode;
    const errorLabel = document.createElement('label');

    errorLabel.classList.add('error-label');
    errorLabel.textContent = text;

    parent.classList.add('error');

    parent.append(errorLabel);
  }

  let result = true;

  const allInputs = form.querySelectorAll('input');

  for (const input of allInputs) {
    removeError(input);

    if (input.dataset.maxLength) {
      if (input.value.length > input.dataset.maxLength) {
        removeError(input);
        createError(
          input,
          `Maximum number of characters: ${input.dataset.maxLength}`
        );
        result = false;
      }
    }

    if (input.dataset.required == 'true') {
      if (input.value == '') {
        removeError(input);
        createError(input, ' Please enter the data.');
        result = false;
      }
    }
  }

  return result;
};

//edit user
window.editUser = (id) => {
  let form = document.getElementById('form');
  if (validation(form) == true) {
    const updateEmail = document.getElementById('email').value;
    const updateName = document.getElementById('name').value;
    const updateGender = document.getElementById('gender').value;
    const updateStatus = document.getElementById('status').value;

    let url = `http://localhost:8080/users/${id}`;

    let b = {
      email: updateEmail,
      name: updateName,
      gender: updateGender,
      status: updateStatus,
    };
    let options = {
      method: 'PUT',
      body: JSON.stringify(b),
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*',
      },
    };

    fetch(url, options).then(() => alert('Edit user successful'));
  }
};

//delete user
window.getCurrentUserId = (id) => {
  let dataId = document.getElementById('userId');
  dataId.value = id;
};

window.deleteUser = () => {
  let id = document.getElementById('userId').value;
  let url = `http://localhost:8080/users/${id}`;
  let options = {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*',
    },
  };

  fetch(url, options).then((response) => location.reload());
};

//validation
(() => {
  'use strict';

  const forms = document.querySelectorAll('.needs-validation');

  Array.from(forms).forEach((form) => {
    form.addEventListener(
      'submit',
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated');
      },
      false
    );
  });
})();

//check all users
window.check_uncheck_checkbox = (isChecked) => {
  if (isChecked) {
    $('input[name="user"]').each(function () {
      this.checked = true;
    });
  } else {
    $('input[name="user"]').each(function () {
      this.checked = false;
    });
  }
};

//delete multiple users

window.getIdCheckedUsers = (num) => {
  if (document.getElementById(`${num}`).checked) {
    let buttonDelete = document.getElementById('button_delete');
    buttonDelete.style.display = 'flex';
    idsCheckedUsers.push(num);
    return num;
  } else {
    let positionUncheckedUser = idsCheckedUsers.indexOf(num);
    idsCheckedUsers.splice(positionUncheckedUser, 1);
  }
};

window.deleteCheckedUsers = () => {
  let url = `http://localhost:8080/users/delete`;
  let options = {
    method: 'DELETE',
    body: JSON.stringify({
      usersIds: idsCheckedUsers,
    }),
  };

  fetch(url, options)
    .then((response) => location.reload())
    .then(() => alert('Users deleted!'));
};

//add user
window.addUser = () => {
  let form = document.getElementById('add-form');

  if (validation(form) == true) {
    const email = document.getElementById('email').value;
    const name = document.getElementById('name').value;
    const gender = document.getElementById('gender').value;
    const status = document.getElementById('status').value;

    let url = `http://localhost:8080/users/addUser`;

    let dataUser = {
      email: email,
      name: name,
      gender: gender,
      status: status,
    };
    let options = {
      method: 'POST',
      body: JSON.stringify(dataUser),
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*',
      },
    };

    fetch(url, options).then((response) => {
      if (response.status == 422) {
        alert('Email already in use, change email!');
      } else {
        window.location.replace(`http://localhost:8080/users/new`);
      }
    });
  }
};
