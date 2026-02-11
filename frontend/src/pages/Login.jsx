import { useState } from 'react'
import { useNavigate } from 'react-router-dom'

const API = 'http://127.0.0.1:8000/api'

export default function Login() {
  const navigate = useNavigate()
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [error, setError] = useState('')

    const submit = async (e) => {
    e.preventDefault()
    setError('')

    await fetch('http://127.0.0.1:8000/sanctum/csrf-cookie', {
        credentials: 'include',
    })

    const res = await fetch(`${API}/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',
        body: JSON.stringify({ email, password }),
    })

    if (!res.ok) {
        const data = await res.json().catch(() => ({}))
        setError(data?.message || 'Invalid email or password')
        return
    }

    navigate('/')
    }


  return (
    <div className="page">
      <h1>Login</h1>
      <form onSubmit={submit} className="options">
        <label>
          Email:
          <input value={email} onChange={(e) => setEmail(e.target.value)} />
        </label>
        <label>
          Password:
          <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} />
        </label>
        {error && <p style={{ color: 'crimson' }}>{error}</p>}
        <button className="btn" type="submit">Login</button>
      </form>
    </div>
  )
}

