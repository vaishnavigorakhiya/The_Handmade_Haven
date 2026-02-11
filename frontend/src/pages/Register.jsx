import { useState } from 'react'
import { useNavigate } from 'react-router-dom'

const API = 'http://127.0.0.1:8000/api'

export default function Register() {
  const navigate = useNavigate()
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [passwordConfirmation, setPasswordConfirmation] = useState('')
  const [fieldErrors, setFieldErrors] = useState({})
  const [error, setError] = useState('')

const submit = async (e) => {
  e.preventDefault()
  setError('')
  setFieldErrors({})

  await fetch('http://127.0.0.1:8000/sanctum/csrf-cookie', {
    credentials: 'include',
  })

  const res = await fetch(`${API}/register`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify({
      name,
      email,
      password,
      password_confirmation: passwordConfirmation,
    }),
  })

  if (!res.ok) {
    const data = await res.json().catch(() => ({}))
    if (data?.errors) {
      setFieldErrors(data.errors)
    } else {
      setError(data?.message || 'Registration failed')
    }
    return
  }

  navigate('/')
}


  return (
    <div className="page">
      <h1>Register</h1>
      <form onSubmit={submit} className="options">
        <label>
          Name:
          <input value={name} onChange={(e) => setName(e.target.value)} />
        </label>
        <label>
          Email:
          <input value={email} onChange={(e) => setEmail(e.target.value)} />
        </label>
        <label>
          Password:
          <input
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
        </label>
        <label>
          Confirm password:
          <input
            type="password"
            value={passwordConfirmation}
            onChange={(e) => setPasswordConfirmation(e.target.value)}
          />
        </label>
        {error && <p style={{ color: 'crimson' }}>{error}</p>}
        {fieldErrors.name && <p style={{ color: 'crimson' }}>{fieldErrors.name[0]}</p>}
        <button className="btn" type="submit">Register</button>
      </form>
    </div>
  )
}
