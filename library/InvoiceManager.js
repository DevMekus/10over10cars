import { fetchData } from "./utils/fetchData";
import html2pdf from "html2pdf.js";

export async function payInvoice(invoiceData) {
  const paymentStatus = true;
  console.log("Paying Invoice gateway..." + invoiceData["userid"]);
  if (paymentStatus) {
    invoiceData.paymentId = "3637263i28JKJH";
    registerPayment(invoiceData);
  }
}
export async function downloadInvoice(invoice, filename) {
  const opt = {
    margin: 1,
    filename: `${filename}.pdf`,
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
  };
  html2pdf().from(invoice).set(opt).save();
}

export async function printInvoice() {
  window.print();
}

export async function registerPayment(data) {
  /**
   * Expecting: Invoiceid, userid,cartItem,tstatus
   */
  console.log("Sending data to back ");
  await fetchData("transaction", "POST", data).then((response) => {
    console.log(response);
    return response;
  });
}
