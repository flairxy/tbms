import ApplicantRepository from './UserRepository'
const repositories = {
    users: ApplicantRepository,
    // other repositories ...
};

export const RepositoryFactory = {
    get: name => repositories[name]
};
