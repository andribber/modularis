export const handleRequest = async (action, error) => {
  try {
    return await action();
  } catch (err) {
    console.log(err);

    if (error) {
      await error();
    }
  }
}