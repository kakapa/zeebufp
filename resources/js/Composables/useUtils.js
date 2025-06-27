export default function dialablePhoneNumber(phone) {
  // Remove all non-numeric characters
  let cleaned = phone.replace(/[^0-9]/g, "");

  // Replace leading zero with +27
  if (cleaned.startsWith("0")) {
    cleaned = "+27" + cleaned.substring(1);
  }

  return `tel:${cleaned}`;
}
