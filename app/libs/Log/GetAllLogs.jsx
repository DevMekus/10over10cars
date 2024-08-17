"use client"

import { API_URL } from "../BaseFile";


const GetAllLogs = async(page, limit) => {
    const response = await fetch(`${API_URL}/log?page=${page}&limit=${limit}`, {
        next: { revalidate: 3600 }
      });
      if (!response.ok) {
        throw new Error("failed to fetch user data");
      }
      const data = await response.json()
        console.log(data)
      return data;
}

export default GetAllLogs
