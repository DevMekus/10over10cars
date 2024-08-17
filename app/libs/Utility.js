export function objectFromFormdata(formData) {
  const formObject = {};

  formData.forEach((value, key) => {
    formObject[key] = value;
  });

  return formObject;
}

export async function readFileBase64(formData = null) {
  if (formData !== null) {
    // Convert FormData to a plain object and handle files
    const formObject = {};
    const filePromises = [];

    formData.forEach((value, key) => {
      if (key === "file_upload") {
        // Convert files to base64 strings and store in the object
        const files = formData.getAll(key);
        formObject[key] = [];

        files.forEach((file) => {
          const filePromise = new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => {
              resolve({
                file_name: file.name,
                file_type: file.type,
                fileContent: reader.result,
              });
            };
            reader.onerror = reject;
            reader.readAsDataURL(file);
          });

          filePromises.push(filePromise);
        });
      } else {
        formObject[key] = value;
      }
    });

    // Wait for all files to be read
    formObject["file_upload"] = await Promise.all(filePromises);

    return formObject;
  }
}

export function timeAgo(phpTimestamp) {
  const now = new Date();
  const timestamp = new Date(phpTimestamp * 1000); // Convert PHP timestamp to milliseconds
  const secondsPast = (now - timestamp) / 1000;

  if (secondsPast < 60) {
    return `${Math.floor(secondsPast)} seconds ago`;
  } else if (secondsPast < 3600) {
    return `${Math.floor(secondsPast / 60)} minutes ago`;
  } else if (secondsPast < 86400) {
    return `${Math.floor(secondsPast / 3600)} hours ago`;
  } else if (secondsPast < 2592000) {
    return `${Math.floor(secondsPast / 86400)} days ago`;
  } else if (secondsPast < 31536000) {
    return `${Math.floor(secondsPast / 2592000)} months ago`;
  } else {
    return `${Math.floor(secondsPast / 31536000)} years ago`;
  }
}

export function greetUser() {
  const currentHour = new Date().getHours(); // Get the current hour (0-23)
  let greeting;

  if (currentHour < 12) {
    greeting = "Good morning";
  } else if (currentHour < 18) {
    greeting = "Good afternoon";
  } else {
    greeting = "Good evening";
  }

  return greeting;
}

export function formatTimestamp(phpTimestamp) {
  // Convert PHP timestamp (which is in seconds) to milliseconds for JavaScript Date
  const date = new Date(phpTimestamp * 1000);

  // Define options for formatting the date
  const options = {
    weekday: "short", // 'Wed'
    month: "short", // 'Oct'
    day: "numeric", // '10'
    year: "numeric", // '2021'
  };

  // Format the date
  return date.toLocaleDateString("en-US", options);
}

export function getCustomUUID(length) {
  let result = "";
  const characters = "0123456789abcdef";
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * characters.length));
  }
  return result;
}
