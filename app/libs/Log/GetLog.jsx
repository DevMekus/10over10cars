"use client"

import { API_URL } from "../BaseFile";
const GetLog = async(userId) => {
    const response = await fetch(`${API_URL}/log/${userId}`, {
        next: { revalidate: 3600 }
      });
      if (!response.ok) {
        throw new Error("failed to fetch user data");
      }
    
      return await response.json();
}

export default GetLog
