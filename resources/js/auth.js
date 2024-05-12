document.getElementById('reset-token-btn').addEventListener('click', function (event) {
    event.preventDefault();
    let userId = document.querySelector('input[name="user_id"]').value;
    resendToken(userId);
});
