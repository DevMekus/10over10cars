import axios from "axios";

export default async function handler(req, res) {
  const { method } = req;
  const { endpoint } = req.query;

  const phpEndpoint = `http://localhost/API_10over10Cars/${endpoint}`;

  try {
    // Configure the request with axios
    const response = await axios({
      url: phpEndpoint,
      method: method,
      headers: {
        "Content-Type": "application/json",
      },
      data: req.body, // axios automatically stringifies the body if Content-Type is set to application/json
    });

    // Send back the response data
    res.status(200).json(response.data);
  } catch (error) {
    // Handle errors and send back an error response

    res.status(error.response.status).json({ error: error.response.data });
  }
}
