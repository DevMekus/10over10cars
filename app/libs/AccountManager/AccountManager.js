import { API_URL } from "../BaseFile";

export const NavWelcome = async (userId) => {
  const response = await fetch(`${API_URL}/welcome/${userId}`, {
    cache: "force-cache",
  });
  if (!response.ok) {
    throw new Error("failed to fetch user data");
  }

  return await response.json();
};
