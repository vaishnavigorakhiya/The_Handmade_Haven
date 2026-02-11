import { useEffect, useState } from 'react'

const API = 'http://127.0.0.1:8000/api'
const PRODUCTS = `${API}/products`



const slugify = (text) =>
  text
    .toLowerCase()
    .trim()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '')

export default function Admin() {
  const [products, setProducts] = useState([])
  const [user, setUser] = useState(null)
  const [authMode, setAuthMode] = useState('login')
  const [authName, setAuthName] = useState('')
  const [authEmail, setAuthEmail] = useState('')
  const [authPassword, setAuthPassword] = useState('')
  const [authPasswordConfirm, setAuthPasswordConfirm] = useState('')
  const [authError, setAuthError] = useState('')

  const [editingId, setEditingId] = useState(null)
  const [name, setName] = useState('')
  const [slug, setSlug] = useState('')
  const [priceInput, setPriceInput] = useState('0.00')
  const [description, setDescription] = useState('')
  const [imageUrl, setImageUrl] = useState('')
  const [imageFile, setImageFile] = useState(null)
  const [options, setOptions] = useState([{ type: 'color', value: '' }])

  const loadProducts = () => {
    fetch(PRODUCTS, { credentials: 'include' })
      .then((res) => res.json())
      .then((data) => setProducts(data))
  }

  const loadMe = () => {
    fetch(`${API}/me`, { credentials: 'include' })
      .then((res) => (res.ok ? res.json() : null))
      .then((data) => setUser(data))
      .catch(() => setUser(null))
  }

  useEffect(() => {
    loadProducts()
    loadMe()
  }, [])

  const submitAuth = async (e) => {
    e.preventDefault()
    setAuthError('')

    await fetch('http://127.0.0.1:8000/sanctum/csrf-cookie', {
      credentials: 'include',
    })

    const payload =
      authMode === 'register'
        ? {
            name: authName,
            email: authEmail,
            password: authPassword,
            password_confirmation: authPasswordConfirm,
          }
        : {
            email: authEmail,
            password: authPassword,
          }

    const res = await fetch(`${API}/${authMode}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify(payload),
    })

    if (!res.ok) {
      setAuthError('Invalid credentials or validation error.')
      return
    }

    const data = await res.json()
    setUser(data)
    setAuthName('')
    setAuthEmail('')
    setAuthPassword('')
    setAuthPasswordConfirm('')
  }

  const logout = async () => {
    await fetch(`${API}/logout`, {
      method: 'POST',
      credentials: 'include',
    })
    setUser(null)
  }

  const resetForm = () => {
    setEditingId(null)
    setName('')
    setSlug('')
    setPriceInput('0.00')
    setDescription('')
    setImageUrl('')
    setImageFile(null)
    setOptions([{ type: 'color', value: '' }])
  }

  const startEdit = (product) => {
    setEditingId(product.id)
    setName(product.name)
    setSlug(product.slug)
    setPriceInput((product.price / 100).toFixed(2))
    setDescription(product.description || '')
    setImageUrl(product.image_url || '')
    setOptions(product.options.map((o) => ({ type: o.type, value: o.value })))
  }

  const addOptionRow = () => {
    setOptions((prev) => [...prev, { type: 'color', value: '' }])
  }

  const updateOption = (index, key, value) => {
    setOptions((prev) =>
      prev.map((o, i) => (i === index ? { ...o, [key]: value } : o))
    )
  }

  const removeOption = (index) => {
    setOptions((prev) => prev.filter((_, i) => i !== index))
  }

  const submitProduct = (e) => {
  e.preventDefault()

  const payload = {
    name,
    slug: slug || slugify(name),
    price: Math.round(Number(priceInput || 0) * 100),
    description,
    image_url: imageUrl,
    options: options.filter((o) => o.type && o.value),
  }

  const method = editingId ? 'PUT' : 'POST'
  const url = editingId ? `${PRODUCTS}/${editingId}` : PRODUCTS

  const form = new FormData()
  Object.entries(payload).forEach(([key, value]) => {
    if (key === 'options') {
      form.append('options', JSON.stringify(value))
    } else if (value !== null && value !== undefined) {
      form.append(key, value)
    }
  })
  if (imageFile) {
    form.append('image', imageFile)
  }

  fetch(url, {
    method,
    credentials: 'include',
    body: form,
  })
    .then((res) => res.json())
    .then(() => {
      resetForm()
      setImageFile(null)
      loadProducts()
    })
}


  const deleteProduct = (id) => {
    fetch(`${PRODUCTS}/${id}`, {
      method: 'DELETE',
      credentials: 'include',
    }).then(() => loadProducts())
  }

  return (
    <div className="page">
      <h1>Admin</h1>

      {!user ? (
        <form onSubmit={submitAuth} className="options">
          <div style={{ display: 'flex', gap: 8 }}>
            <button
              type="button"
              onClick={() => setAuthMode('login')}
              disabled={authMode === 'login'}
            >
              Login
            </button>
            <button
              type="button"
              onClick={() => setAuthMode('register')}
              disabled={authMode === 'register'}
            >
              Register
            </button>
          </div>

          {authMode === 'register' && (
            <label>
              Name:
              <input
                value={authName}
                onChange={(e) => setAuthName(e.target.value)}
                required
              />
            </label>
          )}

          <label>
            Email:
            <input
              type="email"
              value={authEmail}
              onChange={(e) => setAuthEmail(e.target.value)}
              required
            />
          </label>

          <label>
            Password:
            <input
              type="password"
              value={authPassword}
              onChange={(e) => setAuthPassword(e.target.value)}
              required
            />
          </label>

          {authMode === 'register' && (
            <label>
              Confirm password:
              <input
                type="password"
                value={authPasswordConfirm}
                onChange={(e) => setAuthPasswordConfirm(e.target.value)}
                required
              />
            </label>
          )}

          {authError && <p style={{ color: 'crimson' }}>{authError}</p>}

          <button type="submit">
            {authMode === 'login' ? 'Login' : 'Register'}
          </button>
        </form>
      ) : (
        <>
          <p>
            Logged in as <strong>{user.name}</strong>
          </p>
          <button onClick={logout}>Logout</button>

          <h3 style={{ marginTop: 20 }}>Add / Edit Products</h3>
          <form onSubmit={submitProduct} className="options">
            <label>
              Product name:
              <input
                value={name}
                onChange={(e) => {
                  setName(e.target.value)
                  if (!slug) setSlug(slugify(e.target.value))
                }}
                required
              />
            </label>

            <label>
              Slug:
              <input value={slug} onChange={(e) => setSlug(e.target.value)} required />
            </label>

            <label>
              Price (e.g. 12.00):
              <input
                type="number"
                step="0.01"
                value={priceInput}
                onChange={(e) => setPriceInput(e.target.value)}
                required
              />
            </label>

            <label>
              Description:
              <textarea
                value={description}
                onChange={(e) => setDescription(e.target.value)}
              />
            </label>

            <label>
                Image file:
                <input
                    type="file"
                    accept="image/*"
                    onChange={(e) => setImageFile(e.target.files?.[0] || null)}
                />
            </label>

            <label>
                Image URL (optional):
                <input value={imageUrl} onChange={(e) => setImageUrl(e.target.value)} />
            </label>


            <div>
              <strong>Options</strong>
              {options.map((opt, i) => (
                <div key={i} style={{ display: 'flex', gap: 8, marginTop: 6 }}>
                  <select
                    value={opt.type}
                    onChange={(e) => updateOption(i, 'type', e.target.value)}
                  >
                    <option value="color">color</option>
                    <option value="size">size</option>
                    <option value="text">text</option>
                  </select>
                  <input
                    value={opt.value}
                    onChange={(e) => updateOption(i, 'value', e.target.value)}
                    placeholder={opt.type === 'text' ? 'custom' : 'Ivory'}
                  />
                  <button type="button" onClick={() => removeOption(i)}>
                    Remove
                  </button>
                </div>
              ))}
              <button type="button" onClick={addOptionRow} style={{ marginTop: 8 }}>
                Add option
              </button>
            </div>

            <div style={{ display: 'flex', gap: 8 }}>
              <button type="submit">
                {editingId ? 'Update Product' : 'Create Product'}
              </button>
              {editingId && (
                <button type="button" onClick={resetForm}>
                  Cancel Edit
                </button>
              )}
            </div>
          </form>

          <h3 style={{ marginTop: 20 }}>Existing Products</h3>
          <ul>
            {products.map((p) => (
              <li key={p.id} style={{ marginBottom: 8 }}>
                <strong>{p.name}</strong> (${(p.price / 100).toFixed(2)})
                <button onClick={() => startEdit(p)} style={{ marginLeft: 8 }}>
                  Edit
                </button>
                <button onClick={() => deleteProduct(p.id)}>Delete</button>
              </li>
            ))}
          </ul>
        </>
      )}
    </div>
  )
}
