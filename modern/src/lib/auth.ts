import { betterAuth } from "better-auth";
import { prismaAdapter } from "better-auth/adapters/prisma";
import { prisma } from "@/lib/prisma";

if (!process.env.BETTER_AUTH_SECRET) throw new Error("BETTER_AUTH_SECRET is required");
if (!process.env.BETTER_AUTH_URL) throw new Error("BETTER_AUTH_URL is required");

export const auth = betterAuth({
  database: prismaAdapter(prisma, { provider: "postgresql" }),
  baseURL: process.env.BETTER_AUTH_URL,
  secret: process.env.BETTER_AUTH_SECRET,
  emailAndPassword: { enabled: true, autoSignIn: false },
  advanced: { cookiePrefix: "transcamacho" },
  trustedOrigins: [process.env.BETTER_AUTH_URL, "https://transcamacho.com", "https://www.transcamacho.com"],
});
