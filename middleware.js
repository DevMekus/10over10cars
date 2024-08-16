"server only";
import { NextResponse } from "next/server";
import { decrypt } from "./library/session-jose";
import { cookies } from "next/headers";

// 1. Specify protected and public routes
const protectedRoutes = ["/dashboard", "/admin"];
const publicRoutes = ["/auth/login", "/auth/signup"];

export default async function middleware(req) {
  /**test Path */
  const path = req.nextUrl.pathname;
  const isProtectedRoute = protectedRoutes.includes(path);
  const isPublicRoute = publicRoutes.includes(path);

  /**Decypt session */
  const cookie = cookies().get("session")?.value;
  const session = await decrypt(cookie);

  /**Redirect */
  if (isProtectedRoute && !session?.userid) {
    return NextResponse.redirect(
      new URL("/auth/login?auth=false", req.nextUrl)
    );
  }

  if (isPublicRoute && session?.userid) {
    if (
      session.role == "user" &&
      !req.nextUrl.pathname.startsWith("/dashboard", req.nextUrl)
    ) {
      return NextResponse.redirect(new URL("/dashboard", req.nextUrl));
    } else if (
      session.role == "admin" &&
      !req.nextUrl.pathname.startsWith("/admin", req.nextUrl)
    ) {
      return NextResponse.redirect(new URL("/admin", req.nextUrl));
    }
  }

  return NextResponse.next();
}

// Routes Middleware should not run on
export const config = {
  matcher: ["/((?!api|_next/static|_next/image|.*\\.png$).*)"],
};
