<?php 
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../includes/functions.php';

$flash = getFlash();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxPro CA Firm | Expert Financial & Taxation Services</title>
    <meta name="description" content="Professional CA services including Tax Filing, GST, Audit, and Company Registration.">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <nav>
        <a href="#" class="logo">TaxPro <span>CA Firm</span></a>
        <div class="menu-toggle"><i class="fas fa-bars"></i></div>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#about">Why Us</a></li>
            <li><a href="#inquiry-form">Contact Us</a></li>
        </ul>
    </nav>

    <header class="hero" id="home">
        <h1>Simplify Your Taxes, Grow Your Business.</h1>
        <p>Expert Chartered Accountants offering comprehensive financial solutions tailored for startups and established enterprises.</p>
        <a href="#inquiry-form" class="btn-cta">Get Expert Consultation</a>
    </header>

    <section id="services">
        <div class="section-head">
            <h2>Our Premium Services</h2>
            <div class="underline"></div>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <i class="fas fa-file-invoice-dollar"></i>
                <h3>Tax Filing</h3>
                <p>Strategic income tax planning and hassle-free return filing for individuals and firms.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-receipt"></i>
                <h3>GST Registration</h3>
                <p>Complete GST compliance, from registration to monthly returns and advisory.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-magnifying-glass-chart"></i>
                <h3>Audit Services</h3>
                <p>Thorough statutory, internal, and tax audits to ensure compliance and accuracy.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-building"></i>
                <h3>Company Setup</h3>
                <p>Seamless incorporation of Pvt Ltd, LLP, and OPC with all legal requirements.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-calculator"></i>
                <h3>Accounting</h3>
                <p>End-to-end bookkeeping and financial reporting to keep your records crystal clear.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-briefcase"></i>
                <h3>Advisory</h3>
                <p>Expert business consulting, ROC compliance, and financial management.</p>
            </div>
        </div>
    </section>

    <section id="about" style="background:#fff">
        <div class="section-head">
            <h2>Why Choose TaxPro?</h2>
            <div class="underline"></div>
        </div>
        <div class="features-grid">
            <div class="feature-item">
                <i class="fas fa-award"></i>
                <h3>20+ Years</h3>
                <p>Deep-rooted excellence in the industry.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-users"></i>
                <h3>500+ Clients</h3>
                <p>Trusted by domestic and global businesses.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-user-tie"></i>
                <h3>Expert Team</h3>
                <p>Qualified CAs and financial consultants.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-shield-halved"></i>
                <h3>Trusted & Secure</h3>
                <p>Your financial data is safe with us.</p>
            </div>
        </div>
    </section>

    <section id="inquiry-form">
        <div class="section-head">
            <h2>Enquire Now</h2>
            <p>Fill in the form below and our experts will reach out to you within 24 hours.</p>
            <div class="underline"></div>
        </div>

        <div class="form-container">
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                </div>
            <?php endif; ?>

            <form action="submit_inquiry.php" method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" placeholder="E.g. John Doe" value="<?php echo sanitize($old['full_name'] ?? ''); ?>" required>
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com" value="<?php echo sanitize($old['email'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="tel" name="mobile" class="form-control" placeholder="10-digit number" value="<?php echo sanitize($old['mobile'] ?? ''); ?>" required>
                    </div>
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" placeholder="E.g. Mumbai" value="<?php echo sanitize($old['city'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Service Required</label>
                        <select name="service" class="form-control" required>
                            <option value="">-- Select Service --</option>
                            <?php 
                            $services = ['Tax Filing', 'GST Registration', 'Audit', 'Company Registration', 'Accounting', 'Other'];
                            foreach($services as $s): 
                                $sel = (($old['service'] ?? '') == $s) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $s; ?>" <?php echo $sel; ?>><?php echo $s; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Message / Requirements</label>
                    <textarea name="message" class="form-control" rows="4" placeholder="Briefly describe your requirements..." required><?php echo sanitize($old['message'] ?? ''); ?></textarea>
                </div>
                <button type="submit" class="submit-btn">Send Inquiry <i class="fas fa-paper-plane" style="margin-left:8px"></i></button>
            </form>
        </div>
    </section>

    <footer>
        <div class="footer-grid">
            <div>
                <a href="#" class="footer-logo">TaxPro <span>CA Firm</span></a>
                <p>Your strategic partner for tax, audit, and compliance across India.</p>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <a href="#home">Home</a>
                <a href="#services">Services</a>
                <a href="#about">About Us</a>
                <a href="/admin/login.php">Admin Login</a>
            </div>
            <div>
                <h4>Contact Info</h4>
                <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                <p><i class="fas fa-envelope"></i> contact@cafirm.com</p>
                <p><i class="fas fa-location-dot"></i> 402, Business Park, Outer Ring Road, Bangalore</p>
            </div>
        </div>
        <div class="copy">
            &copy; <?php echo date('Y'); ?> TaxPro CA Firm. All Rights Reserved. Designed by Antigravity.
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
