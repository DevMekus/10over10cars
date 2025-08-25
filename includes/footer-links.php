 <!-- Footer -->
 <footer id="contact" role="contentinfo">
     <div class="container footer-grid">
         <div class="footer-col">
             <div class="brand"><span class="brand-logo">10</span><span>10over10 Cars</span></div>
             <p style="color:#a8b3c5;">Empowering Nigerians to buy and sell cars with confidence through trustworthy verification.</p>
             <div style="display:flex; gap:10px; margin-top:6px;">
                 <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                 <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                 <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                 <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
             </div>
         </div>
         <div class="footer-col">
             <strong>Product</strong>
             <a href="#verify">Verify VIN</a>
             <a href="#market">Buy Cars</a>
             <a href="#sell">Sell Your Car</a>
             <a href="#pricing">Pricing</a>
         </div>
         <div class="footer-col">
             <strong>Company</strong>
             <a href="#">About</a>
             <a href="#">Careers</a>
             <a href="#">Partners</a>
             <a href="#">Press</a>
         </div>
         <div class="footer-col">
             <strong>Support</strong>
             <a href="#faq">Help Center</a>
             <a href="#contact">Contact</a>
             <a href="#">Terms</a>
             <a href="#">Privacy</a>
             <a href="#">Data Policy</a>
         </div>
         <div class="footer-col" style="grid-column: 1 / -1;">
             <form class="newsletter" novalidate>
                 <label for="newsletter" class="sr-only">Email address</label>
                 <input id="newsletter" type="email" placeholder="Enter your email for updates" aria-label="Email address" />
                 <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i> Subscribe</button>
             </form>
         </div>
     </div>
     <div class="copyright">
         © <span id="year"></span> 10over10 Cars. All rights reserved.
     </div>
 </footer>

 <!-- Sticky Mobile Verify Button -->
 <a class="btn btn-primary sticky-mobile-verify" href="#verify" aria-label="Verify VIN"><i class="bi bi-shield-check"></i> Verify</a>

 <!-- Back to top -->
 <button id="backToTop" class="btn btn-outline back-to-top" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

 <!-- Compare Drawer -->
 <div id="compareDrawer" class="compare-drawer" role="dialog" aria-modal="false" aria-labelledby="compareTitle">
     <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
         <strong id="compareTitle">Compare</strong>
         <button id="compareClose" class="btn btn-outline" type="button" aria-label="Close compare"><i class="bi bi-x"></i></button>
     </div>
     <div id="compareBody" class="grid grid-3" style="margin-top:10px;"></div>
 </div>

 <!-- Cookie Banner -->
 <div id="cookieBanner" class="card" style="position: fixed; inset-inline: 12px; bottom: 12px; padding: 12px; z-index: 70; display:none;">
     <p style="margin:0 0 8px;">We use cookies to improve your experience. By using our site, you agree to our cookie policy.</p>
     <div style="display:flex; gap:10px; justify-content:flex-end;">
         <button id="cookieAccept" class="btn btn-primary" type="button">Accept</button>
         <button id="cookieDecline" class="btn btn-outline" type="button">Decline</button>
     </div>
 </div>