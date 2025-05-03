// Mobile Navigation Toggle
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    hamburger.classList.toggle('active');
});

// Smooth Scrolling for Navigation Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Sticky Header
const header = document.querySelector('.header');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll <= 0) {
        header.classList.remove('scroll-up');
        return;
    }
    
    if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
        header.classList.remove('scroll-up');
        header.classList.add('scroll-down');
    } else if (currentScroll < lastScroll && header.classList.contains('scroll-down')) {
        header.classList.remove('scroll-down');
        header.classList.add('scroll-up');
    }
    lastScroll = currentScroll;
});

// Form Validation
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const name = contactForm.querySelector('input[name="name"]').value;
        const email = contactForm.querySelector('input[name="email"]').value;
        const message = contactForm.querySelector('textarea[name="message"]').value;
        
        if (!name || !email || !message) {
            alert('Please fill in all fields');
            return;
        }
        
        if (!isValidEmail(email)) {
            alert('Please enter a valid email address');
            return;
        }
        
        // Here you would typically send the form data to the server
        // For now, we'll just show a success message
        alert('Thank you for your message! We will get back to you soon.');
        contactForm.reset();
    });
}

// Email validation helper
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Intersection Observer for Animations
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe elements that should animate
document.querySelectorAll('.service-card, .doctors-grid > div, .stat-item').forEach(el => {
    observer.observe(el);
});

// Appointment Booking Modal
const appointmentBtn = document.querySelector('a[href="#appointment"]');
if (appointmentBtn) {
    appointmentBtn.addEventListener('click', (e) => {
        e.preventDefault();
        // Create and show appointment modal
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Book an Appointment</h2>
                <form id="appointment-form">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="tel" name="phone" placeholder="Your Phone" required>
                    <select name="department" required>
                        <option value="">Select Department</option>
                        <option value="general">General Medicine</option>
                        <option value="cardiology">Cardiology</option>
                        <option value="orthopedics">Orthopedics</option>
                        <option value="pediatrics">Pediatrics</option>
                    </select>
                    <input type="date" name="date" required>
                    <textarea name="message" placeholder="Additional Information"></textarea>
                    <button type="submit" class="btn-primary">Book Appointment</button>
                </form>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Close modal when clicking the close button
        modal.querySelector('.close').addEventListener('click', () => {
            modal.remove();
        });
        
        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
        
        // Handle form submission
        const form = modal.querySelector('#appointment-form');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            // Here you would typically send the appointment data to the server
            alert('Appointment booked successfully! We will contact you shortly.');
            modal.remove();
        });
    });
}

// Add CSS for modal
const style = document.createElement('style');
style.textContent = `
    .modal {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    
    .modal-content {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        max-width: 500px;
        width: 90%;
        position: relative;
    }
    
    .close {
        position: absolute;
        right: 1rem;
        top: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
    }
    
    #appointment-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    #appointment-form input,
    #appointment-form select,
    #appointment-form textarea {
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
`;

document.head.appendChild(style); 