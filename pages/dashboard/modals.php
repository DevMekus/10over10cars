 <!-- Modals -->
 <div class="modal" id="vehicleModal" aria-hidden="true">
     <div class="modal-card">
         <div class="modal-header">
             <h3 id="vehicleModalTitle">Add Vehicle</h3><button class="icon-btn" data-close="vehicleModal">✕</button>
         </div>
         <form id="vehicleForm">
             <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px">
                 <div><label>Title</label><input type="text" id="vTitle" required /></div>
                 <div><label>Price (NGN)</label><input type="number" id="vPrice" required /></div>
                 <div><label>VIN</label><input type="text" id="vVin" required /></div>
                 <div><label>Status</label><select id="vStatus">
                         <option value="available">Available</option>
                         <option value="pending">Pending</option>
                         <option value="sold">Sold</option>
                     </select></div>
             </div>
             <div style="margin-top:12px"><label>Image (optional)</label><input type="file" id="vImage" accept="image/*" /></div>
             <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px"><button type="button" class="btn btn-ghost" data-close="vehicleModal">Cancel</button><button type="submit" class="btn btn-primary">Save Vehicle</button></div>
         </form>
     </div>
 </div>

 <div class="modal" id="dealerModal" aria-hidden="true">
     <div class="modal-card">
         <div class="modal-header">
             <h3>Approve Dealer</h3><button class="icon-btn" data-close="dealerModal">✕</button>
         </div>
         <form id="approveDealerForm">
             <div style="margin-top:12px"><label>Dealer ID</label><input type="text" id="dealerId" readonly /></div>
             <div style="margin-top:12px"><label>Company</label><input type="text" id="dealerCompany" readonly /></div>
             <div style="margin-top:12px"><label>Decision</label><select id="dealerDecision">
                     <option value="approve">Approve</option>
                     <option value="reject">Reject</option>
                 </select></div>
             <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px"><button type="button" class="btn btn-ghost" data-close="dealerModal">Cancel</button><button type="submit" class="btn btn-primary">Submit</button></div>
         </form>
     </div>
 </div>
 <!-- Details modal -->
 <div class="modal" id="detailModal" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center">
             <h3>Verification details</h3><button class="icon-btn" data-close="detailModal">✕</button>
         </div>
         <div style="margin-top:12px" class="modal-grid">
             <div>
                 <div class="vehicle-media"><img id="detailImage" src="https://source.unsplash.com/800x600/?car" alt="vehicle image" /></div>
                 <div style="margin-top:10px;display:flex;gap:8px"><button class="btn btn-primary" id="approveBtn">Approve</button><button class="btn btn-ghost" id="declineBtn">Decline</button></div>
             </div>
             <div>
                 <div><strong id="detailTitle">2016 Toyota Corolla</strong>
                     <div class="muted small" id="detailMeta">Lagos • 72,000 km</div>
                 </div>
                 <div style="margin-top:10px"><strong>VIN</strong>
                     <div class="small" id="detailVin">2HGFB2F50DH512345</div>
                 </div>
                 <div style="margin-top:10px"><strong>Submitted by</strong>
                     <div class="small" id="detailUser">Nnaemeka N. (dealer: Ace Motors)</div>
                 </div>
                 <div style="margin-top:10px"><strong>Documents</strong>
                     <ul id="detailDocs" style="margin:6px 0 0 14px"></ul>
                 </div>
                 <div style="margin-top:12px"><strong>Notes</strong>
                     <div id="detailNotes" class="muted small">No additional notes</div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal: Report Issue -->
 <div class="modal" id="reportModal" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center"><strong>Report an issue</strong><button class="icon-btn" data-close="reportModal">✕</button></div>
         <form id="reportForm" style="margin-top:12px;display:grid;gap:8px">
             <label class="small muted">Describe the issue<textarea name="issue" rows="4" style="width:100%;padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)"></textarea></label>
             <div style="display:flex;gap:8px;justify-content:flex-end">
                 <button type="submit" class="btn primary">Send report</button>
                 <button type="button" class="btn ghost" data-close="reportModal">Cancel</button>
             </div>
         </form>
     </div>
 </div>

 <!-- Detail modal -->
 <div class="modal" id="detailModalTx" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center">
             <h3>Transaction details</h3><button class="icon-btn" data-close="detailModal">✕</button>
         </div>
         <div style="margin-top:12px" class="modal-grid">
             <div>
                 <div style="background:#f3f6fb;padding:12px;border-radius:8px"><strong id="txId">TXN-000</strong>
                     <div class="muted small" id="txDate">2025-01-01</div>
                 </div>
                 <div style="margin-top:12px"><strong>Amount</strong>
                     <div id="txAmount" class="big">NGN 0</div>
                 </div>
                 <div style="margin-top:12px"><strong>Method</strong>
                     <div id="txMethod" class="muted small">Card</div>
                 </div>
                 <div style="margin-top:12px"><strong>Status</strong>
                     <div id="txStatus" class="muted small">Pending</div>
                 </div>
                 <div style="margin-top:12px"><strong>Action</strong>
                     <div style="display:flex;gap:8px;margin-top:8px"><button class="btn btn-primary" id="refundBtn">Refund</button><button class="btn btn-ghost" id="blockBtn">Block</button></div>
                 </div>
             </div>
             <div>
                 <div><strong>User/Dealer</strong>
                     <div id="txUser" class="muted small">John Doe</div>
                 </div>
                 <div style="margin-top:12px"><strong>Notes</strong>
                     <div id="txNotes" class="muted small">—</div>
                 </div>
                 <div style="margin-top:12px"><strong>Receipt / Logs</strong>
                     <div id="txLogs" class="muted small">No logs</div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Dealer Detail Modal -->
 <div class="modal" id="detailModalDealer" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center">
             <h3>Dealer details</h3><button class="ghost" data-close="detailModal">✕</button>
         </div>
         <div id="detailBody" style="margin-top:10px"></div>
         <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
             <button id="approveBtn" class="ghost">Approve</button>
             <button id="suspendBtn" class="ghost">Suspend</button>
             <button id="deleteBtn" class="ghost">Delete</button>
         </div>
     </div>
 </div>

 <!-- Add Dealer Modal -->
 <div class="modal" id="addModal" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center">
             <h3>Add dealer</h3><button class="ghost" data-close="addModal">✕</button>
         </div>
         <form id="addForm" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px">
             <div><label class="small muted">Dealer name</label><input required name="name" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">Email</label><input type="email" required name="email" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">Phone</label><input required name="phone" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">City/State</label><input required name="state" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div style="grid-column:1/-1"><label class="small muted">About</label><textarea name="about" rows="3" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px"></textarea></div>
             <div style="grid-column:1/-1;display:flex;gap:8px;justify-content:flex-end"><button type="submit" class="ghost">Save</button></div>
         </form>
     </div>
 </div>

 <!-- Confirmation modal -->
 <div class="modal" id="confirmModal" aria-hidden="true">
     <div class="modal-card" data-aos="zoom-in">
         <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;border-bottom:1px solid rgba(15,23,36,0.06)"><strong>Submit application?</strong><button class="icon-btn"><i class="bi bi-x-lg"></i></button></div>
         <div style="padding:16px">
             <p class="muted">
                 You are about to submit your dealer application. Please ensure all details are correct. Our verification team will review your submission and contact you with the next steps.
             </p>

             <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
                 <button class="btn btn-ghost">Cancel</button>
                 <button id="confirmSubmit" class="btn btnpro
                 ">Yes, submit</button>
             </div>
         </div>
     </div>
 </div>


 <!-- Detail Modal -->
 <div class="modal" id="detailModalVehi" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center">
             <h3>Vehicle details</h3><button class="toolbar btn" data-close="detailModal">✕</button>
         </div>
         <div id="detailBodyVehi" style="margin-top:10px"></div>
         <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
             <button id="approveBtn" class="btn">Approve</button>
             <button id="rejectBtn" class="btn">Reject</button>
             <button id="deleteBtn" class="btn">Delete</button>
         </div>
     </div>
 </div>

 <!-- Add/Edit Modal -->
 <div class="modal" id="formModal" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center">
             <h3 id="formTitle">Add vehicle</h3><button class="toolbar btn" data-close="formModal">✕</button>
         </div>
         <form id="vehForm" style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:10px">
             <div><label class="small muted">Make</label><input required name="make" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">Model</label><input required name="model" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">Year</label><input required type="number" min="1980" max="2030" name="year" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">VIN</label><input required minlength="11" maxlength="17" name="vin" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">Mileage (km)</label><input required type="number" name="mileage" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">Price (NGN)</label><input required type="number" name="price" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">Owner/Dealer</label><input required name="owner" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div><label class="small muted">Status</label>
                 <select name="status" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px">
                     <option value="pending">Pending</option>
                     <option value="approved">Approved</option>
                     <option value="rejected">Rejected</option>
                     <option value="draft">Draft</option>
                 </select>
             </div>
             <div style="grid-column:1/-1"><label class="small muted">Image URL</label><input name="image" placeholder="https://..." style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
             <div style="grid-column:1/-1"><label class="small muted">Notes</label><textarea name="notes" rows="3" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px"></textarea></div>
             <div style="grid-column:1/-1;display:flex;gap:8px;justify-content:flex-end"><button type="submit" class="btn primary">Save</button></div>
         </form>
     </div>
 </div>

 <!-- Modals -->
 <div class="modal" id="passwordModal" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center"><strong>Change password</strong><button class="btn ghost" data-close="passwordModal">✕</button></div>
         <form id="passwordForm" style="margin-top:12px">
             <label>Current password</label><input type="password" id="curPass" required />
             <label style="margin-top:8px">New password</label><input type="password" id="newPass" required />
             <label style="margin-top:8px">Confirm new password</label><input type="password" id="confirmPass" required />
             <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px"><button type="submit" class="btn primary">Change password</button></div>
         </form>
     </div>
 </div>

 <div class="modal" id="confirmModal" aria-hidden="true">
     <div class="modal-card">
         <div style="display:flex;justify-content:space-between;align-items:center"><strong id="confirmTitle">Confirm</strong><button class="btn ghost" data-close="confirmModal">✕</button></div>
         <div id="confirmBody" style="margin-top:10px"></div>
         <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px"><button id="confirmOk" class="btn primary">Yes</button><button class="btn ghost" data-close="confirmModal">Cancel</button></div>
     </div>
 </div>

 <!-- Change Password Modal -->
 <div class="modal" id="passModal" aria-hidden="true">
     <div class="modal-card" data-aos="zoom-in">
         <div style="padding:12px 16px;border-bottom:1px solid rgba(15,23,36,0.06);display:flex;justify-content:space-between;align-items:center"><strong>Change password</strong><button class="icon-btn" onclick="closeModal('passModal')"><i class="bi bi-x-lg"></i></button></div>
         <div style="padding:16px">
             <form id="passForm" style="display:grid;gap:10px">
                 <label>Current password<input class="input" name="current" type="password" required /></label>
                 <label>New password<input class="input" name="newp" type="password" required /></label>
                 <label>Confirm password<input class="input" name="confirm" type="password" required /></label>
                 <div style="display:flex;justify-content:flex-end;gap:8px"><button type="button" class="btn btn-ghost">Cancel</button><button type="submit" class="action-btn">Update password</button></div>
             </form>
         </div>
     </div>
 </div>

 <!-- Delete confirm Modal -->
 <div class="modal" id="delModal" aria-hidden="true">
     <div class="modal-card" data-aos="zoom-in">
         <div style="padding:12px 16px;border-bottom:1px solid rgba(15,23,36,0.06);display:flex;justify-content:space-between;align-items:center"><strong>Delete account</strong><button class="icon-btn" onclick="closeModal('delModal')"><i class="bi bi-x-lg"></i></button></div>
         <div style="padding:16px">
             <p class="muted">This action is irreversible in production. In this demo it will clear local demo data. Proceed?</p>
             <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px"><button class="btn btn-ghost">Cancel</button><button id="confirmDelete" class="action-btn" style="background:linear-gradient(90deg,#ef4444,#f97316)">Delete</button></div>
         </div>
     </div>
 </div>

 <!-- DETAIL MODAL -->
 <div class="modal" id="detailModal" aria-hidden="true">
     <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="detailTitle">
         <div style="display:flex;justify-content:space-between;align-items:center">
             <h3 id="detailTitle">Notification</h3><button class="icon-btn" data-close="detailModal" aria-label="Close">✕</button>
         </div>
         <div id="detailBody" style="margin-top:12px"></div>
         <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
             <button id="detailMark" class="btn ghost">Mark read</button>
             <button id="detailArchive" class="btn ghost">Archive</button>
             <button id="detailDelete" class="btn" style="background:var(--danger);color:#fff">Delete</button>
         </div>
     </div>
 </div>

 <!-- CREATE MODAL -->
 <div class="modal" id="createModal" aria-hidden="true">
     <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="createTitle">
         <div style="display:flex;justify-content:space-between;align-items:center">
             <h3 id="createTitle">Create / Broadcast Notification</h3><button class="icon-btn" data-close="createModal" aria-label="Close">✕</button>
         </div>
         <form id="createForm" style="margin-top:12px;display:grid;gap:8px">
             <label>Title<input name="title" required placeholder="Short title" style="width:100%;padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)"></label>
             <label>Message<textarea name="message" required rows="4" style="width:100%;padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)"></textarea></label>
             <div style="display:flex;gap:8px;flex-wrap:wrap">
                 <select name="type" style="padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)">
                     <option value="system">System</option>
                     <option value="user">User</option>
                     <option value="dealer">Dealer</option>
                     <option value="transaction">Transaction</option>
                 </select>
                 <select name="priority" style="padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)">
                     <option value="normal">Normal</option>
                     <option value="high">High</option>
                     <option value="low">Low</option>
                 </select>
                 <label style="display:flex;align-items:center;gap:6px"><input type="checkbox" name="broadcast"> Broadcast to all</label>
             </div>
             <div style="display:flex;gap:8px;justify-content:flex-end"><button type="submit" class="btn primary">Send</button><button type="button" class="btn ghost" data-close="createModal">Cancel</button></div>
         </form>
     </div>
 </div>
 <!-- Toasts -->
 <div class="toast-wrap" id="toastWrap"></div>