document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.tasks-body').closest('form');
    const inputs = form.querySelectorAll('input[type="text"], select');

    inputs.forEach(element => {
        element.addEventListener('change', function() {
            const formData = new FormData(form);
            const row = element.closest('tr');

            // Add the effect class
            row.classList.add('saving-effect');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Form submitted successfully');
                } else {
                    console.error('Form submission failed', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                // Remove the effect class after a delay
                setTimeout(() => {
                    row.classList.remove('saving-effect');
                }, 1000);
            });
        });
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('createTaskModal');
    const closeModalButton = document.getElementById('closeModal');

    // Open modal function
    function openModal() {
        modal.showModal();
    }

    // Close modal function
    function closeModal() {
        modal.close();
    }

    // Add event listener for the shortcut
    document.addEventListener('keydown', function(event) {
        if ((event.ctrlKey || event.metaKey) && event.key === 't') {
            event.preventDefault();
            openModal();
        }
    });

    // Add close modal event listener
    closeModalButton.addEventListener('click', function() {
        closeModal();
    });

    // Close modal when clicking outside of it
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Delete task functionality
    document.querySelectorAll('.delete-task-button').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            const row = this.closest('tr');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    row.remove();
                    console.log('Task deleted successfully');
                } else {
                    console.error('Task deletion failed', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
