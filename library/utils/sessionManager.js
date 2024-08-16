"use server";
import { createSession, createSessionData } from "../session-jose";
import { redirect } from "next/navigation";
import { decrypt } from "../session-jose";
import { cookies } from "next/headers";

export async function sessionManager(data) {
  /**
   * Creates session and redirects to the right dashboard
   */
  const session = createSession(data);

  if (session) {
    data["role"] && data["role"] == "admin"
      ? redirect("/admin")
      : redirect("/dashboard");
  } else {
    redirect("/auth/login?auth=false");
  }
}

export async function getSession() {
  const cookie = cookies().get("session")?.value;
  const session = await decrypt(cookie);

  if (session?.userid) {
    return session["userid"]["userid"];
  }
  return null;
}

export async function verifySessionRole(path) {
  /**
   * Verifies user session on the layout
   */
  const cookie = cookies().get("session")?.value;
  const session = await decrypt(cookie);

  if (session?.userid) {
    const role = session["role"];

    if (path.includes("/admin") && role != "admin") {
      redirect("/dashboard");
    }

    if (path.includes("/dashboard") && role != "user") {
      redirect("/admin");
    }
  } else {
    redirect("/auth/login?auth=false");
  }
}

export async function saveSessionData(data) {
  return createSessionData(data);
}
