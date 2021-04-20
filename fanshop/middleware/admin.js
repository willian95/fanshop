export default function ({ store, redirect }) {
    // If the user is not authenticated
    if (store.state.auth.user.role_id != 1) {
      return redirect('/')
    }
  }