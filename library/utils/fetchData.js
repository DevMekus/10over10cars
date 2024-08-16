export const fetchData = async (endpoint, method = "GET", body = null) => {
  let options = {
    method,
    headers: {
      "Content-Type": "application/json",
    },
  };

  if (body) {
    options.body = JSON.stringify(body);
  }

  try {
    const response = await fetch(`/api/proxy?endpoint=${endpoint}`, options);

    if (!response.ok) {
      return response.statusText;
    }

    return await response.json();
  } catch (error) {
    throw new Error(error.message);
  }
};
