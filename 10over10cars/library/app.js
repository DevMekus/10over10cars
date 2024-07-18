MyApp.getInitialProps = async ({ ctx }) => {
  const currentUrl = ctx.req ? ctx.req.url : "";
  let pageProps = {};

  if (Component.getInitialProps) {
    pageProps = await Component.getInitialProps(ctx);
  }

  return { pageProps, currentUrl };
};
