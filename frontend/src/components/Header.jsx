import { Link } from 'react-router-dom'
import { useState } from 'react'
import '../styles/Header.css'

const API = 'http://127.0.0.1:8000/api'

export default function Header({ user, onUserUpdate }) {
  const [open, setOpen] = useState(false)
  const [form, setForm] = useState({
    name: user?.name || '',
    email: user?.email || '',
    date_of_birth: user?.date_of_birth || '',
    phone: user?.phone || '',
  })
  const [error, setError] = useState('')

  const save = async (e) => {
    e.preventDefault()
    setError('')

    const res = await fetch(`${API}/profile`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify(form),
    })

    if (!res.ok) {
      setError('Update failed')
      return
    }

    const updated = await res.json()
    onUserUpdate(updated)
    setOpen(false)
  }

  return (
    <header className="site-header">
      <div className="header-inner container">
        <div className="brand">Handcrafted Store</div>
        <nav>
          <Link to="/">Home</Link>
          <Link to="/shop">Shop</Link>
          <Link to="/cart">Cart</Link>

          {user ? (
            <button className="btn" onClick={() => setOpen(!open)}>
              {user.name}
            </button>
          ) : (
            <>
              <Link to="/login">Login</Link>
              <Link to="/register">Register</Link>
            </>
          )}
        </nav>
      </div>

      {user && open && (
        <div className="container">
          <form onSubmit={save} className="profile-form">
            <label>
              Name:
              <input
                value={form.name}
                onChange={(e) => setForm({ ...form, name: e.target.value })}
              />
            </label>
            <label>
              Email:
              <input
                value={form.email}
                onChange={(e) => setForm({ ...form, email: e.target.value })}
              />
            </label>
            <label>
              Date of birth:
              <input
                type="date"
                value={form.date_of_birth || ''}
                onChange={(e) => setForm({ ...form, date_of_birth: e.target.value })}
              />
            </label>
            <label>
              Phone:
              <input
                value={form.phone || ''}
                onChange={(e) => setForm({ ...form, phone: e.target.value })}
              />
            </label>
            {error && <p style={{ color: 'crimson' }}>{error}</p>}
            <button className="btn" type="submit">Save</button>
          </form>
        </div>
      )}
    </header>
  )
}


