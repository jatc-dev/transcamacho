import { createAuthClient } from "better-auth/react";
export const { signIn, signOut, signUp, useSession } = createAuthClient({ baseURL: typeof window !== "undefined" ? window.location.origin : process.env.BETTER_AUTH_URL });
