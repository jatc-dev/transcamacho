import { toNextJsHandler } from "better-auth/next-js";

async function getAuthHandlers() {
  const { auth } = await import("@/lib/auth");
  return toNextJsHandler(auth);
}

export async function GET(request: Request) {
  const handlers = await getAuthHandlers();
  return handlers.GET(request);
}

export async function POST(request: Request) {
  const handlers = await getAuthHandlers();
  return handlers.POST(request);
}
