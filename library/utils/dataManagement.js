import { fetchData } from "./fetchData";

export async function getAccountSummary(sessionId) {
  /**
   * Get verifications
   */
  //   const verifications = await fetchData(`vehicle/${sessionId}`, "GET");
  const support = await fetchData(`support/${sessionId}`, "GET");

  return {
    support,
  };
}
