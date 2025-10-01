console.log('BankKz Theme JS Loading...');
alert('BankKz Theme JavaScript is working!');

class MainSlider {
    constructor() {
        console.log('MainSlider constructor called');
        this.slider = document.getElementById('mainSlider');
        this.prevBtn = document.getElementById('prevBtn');
        this.nextBtn = document.getElementById('nextBtn');
        this.dotsContainer = document.getElementById('sliderDots');

        if (!this.slider) return; // Guard clause for WordPress pages without slider

        this.slides = this.slider.querySelectorAll('.slide');
        this.currentIndex = 0;
        this.maxIndex = this.slides.length - 1;

        this.init();
    }

    init() {
        this.createDots();
        this.updateSlider();
        this.bindEvents();

        // Auto-slide every 6 seconds
        this.autoSlideInterval = setInterval(() => {
            this.next();
        }, 6000);

        // Pause auto-slide on hover
        this.slider.parentElement.addEventListener('mouseenter', () => {
            clearInterval(this.autoSlideInterval);
        });

        this.slider.parentElement.addEventListener('mouseleave', () => {
            this.autoSlideInterval = setInterval(() => {
                this.next();
            }, 6000);
        });
    }

    createDots() {
        this.dotsContainer.innerHTML = '';

        for (let i = 0; i < this.slides.length; i++) {
            const dot = document.createElement('div');
            dot.className = 'dot';
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => this.goToSlide(i));
            this.dotsContainer.appendChild(dot);
        }
    }

    bindEvents() {
        this.prevBtn.addEventListener('click', () => this.prev());
        this.nextBtn.addEventListener('click', () => this.next());

        // Touch/swipe support
        let startX = 0;
        let isDragging = false;

        this.slider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });

        this.slider.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
        });

        this.slider.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;

            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;

            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') this.prev();
            if (e.key === 'ArrowRight') this.next();
        });
    }

    updateSlider() {
        const translateX = -(this.currentIndex * 100);
        this.slider.style.transform = `translateX(${translateX}%)`;

        // Update dots
        const dots = this.dotsContainer.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentIndex);
        });
    }

    prev() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
        } else {
            this.currentIndex = this.maxIndex; // Loop to last slide
        }
        this.updateSlider();
    }

    next() {
        if (this.currentIndex < this.maxIndex) {
            this.currentIndex++;
        } else {
            this.currentIndex = 0; // Loop back to start
        }
        this.updateSlider();
    }

    goToSlide(index) {
        this.currentIndex = index;
        this.updateSlider();
    }
}

// Preloader functionality
window.addEventListener('load', () => {
    const preloader = document.getElementById('preloader');
    const loadingProgress = document.getElementById('loadingProgress');

    if (!preloader) return; // Guard clause if preloader is disabled

    // Simulate loading progress (faster)
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 25 + 10; // Faster increment
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);

            // Hide preloader after progress completes (shorter delay)
            setTimeout(() => {
                preloader.classList.add('fade-out');
            }, 300);
        }
        if (loadingProgress) {
            loadingProgress.style.width = progress + '%';
        }
    }, 150); // Faster interval
});

// Initialize when DOM is ready or already loaded
function initBankzTheme() {
    console.log('Initializing BankKz Theme...');

    try {
        new MainSlider();
    } catch (error) {
        console.error('MainSlider initialization failed:', error);
    }

    // Calculator button functionality
    const calcButton = document.querySelector('.calc-button');
    if (calcButton) {
        calcButton.addEventListener('click', () => {
            // This will be dynamically set via WordPress admin
            const calcUrl = calcButton.getAttribute('data-calc-url') || '#';
            if (calcUrl !== '#') {
                window.open(calcUrl, '_blank');
            }
        });
    }

    // Load More Posts functionality
    let currentPage = 1;
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const articlesGrid = document.querySelector('.articles-grid');

    if (loadMoreBtn && typeof bankz_ajax !== 'undefined') {
        loadMoreBtn.addEventListener('click', function() {
            const button = this;
            const originalText = button.textContent;

            // Change button state to loading
            button.textContent = bankz_ajax.loading_text;
            button.disabled = true;
            button.classList.add('loading');

            // Prepare form data
            const formData = new FormData();
            formData.append('action', 'bankz_load_more_posts');
            formData.append('page', currentPage + 1);
            formData.append('posts_per_page', 6);
            formData.append('nonce', bankz_ajax.nonce);

            // Make AJAX request
            fetch(bankz_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new posts to grid with fade-in animation
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.data.html;

                    const newPosts = tempDiv.querySelectorAll('.article-card');
                    newPosts.forEach((post, index) => {
                        post.style.opacity = '0';
                        post.style.transform = 'translateY(20px)';
                        articlesGrid.appendChild(post);

                        // Animate in with delay
                        setTimeout(() => {
                            post.style.transition = 'all 0.5s ease';
                            post.style.opacity = '1';
                            post.style.transform = 'translateY(0)';
                        }, index * 100);
                    });

                    currentPage++;

                    // Check if there are more posts
                    if (!data.data.has_more) {
                        button.textContent = bankz_ajax.no_more_text;
                        button.disabled = true;
                        button.classList.add('no-more');
                    } else {
                        button.textContent = originalText;
                        button.disabled = false;
                        button.classList.remove('loading');
                    }
                } else {
                    // Handle error
                    button.textContent = bankz_ajax.no_more_text;
                    button.disabled = true;
                    button.classList.add('no-more');
                    console.error('Error loading posts:', data.data);
                }
            })
            .catch(error => {
                console.error('AJAX error:', error);
                button.textContent = originalText;
                button.disabled = false;
                button.classList.remove('loading');

                // Show error message briefly
                const errorMsg = document.createElement('div');
                errorMsg.textContent = 'Ошибка загрузки. Попробуйте еще раз.';
                errorMsg.className = 'load-error';
                button.parentNode.appendChild(errorMsg);

                setTimeout(() => {
                    if (errorMsg.parentNode) {
                        errorMsg.parentNode.removeChild(errorMsg);
                    }
                }, 3000);
            });
        });
    }

    // Smooth scroll for internal links
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

    // View counter functionality
    if (typeof bankz_ajax !== 'undefined') {
        // Track page view for analytics
        const postId = bankz_ajax.post_id;
        if (postId) {
            fetch(bankz_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=bankz_track_view&post_id=${postId}&nonce=${bankz_ajax.nonce}`
            });
        }
    }
}

// Initialize the theme
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBankzTheme);
} else {
    initBankzTheme();
}